<?php

namespace Benchmark_Routing\Kit\Benchmark;

use Benchmark_Routing\Kit\Benchmark\Register as Benchmarks;
use Benchmark_Routing\Kit\Provider\Register as Providers;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\ConsoleOutput;

use function get_class;
use function microtime;
use function shell_exec;
use function sprintf;

/**
* Quick benchmark to calculate routes matched per second
*/
class Quick
{
	/**
	* @var array what bench cases to call for each benchmark
	*/
	const benchCases = array(
		'benchAll',
		'benchLongest',
		'benchLast',
		'benchSetup',
		);

	/**
	* @var string path to current script, e.g. $PHP_SELF
	*/
	protected $script;

	/**
	* Constructor: either execute a benchmark or print out the report
	*
	* @param array $argv
	*/
	function __construct(array $argv)
	{
		$this->script = $argv[0];

		$benchIndex = $argv[1] ?? '';
		$benchCase = $argv[2] ?? '';
		$providerName = $argv[3] ?? '';

		('' === $benchIndex)
			? $this->report()
			: $this->run($benchIndex, $benchCase, $providerName);
	}

	/**
	* Generates and prints the report with all the benchmarks for all the providers
	*/
	function report()
	{
		$output = new ConsoleOutput;

		$results = array();
		foreach (Providers::getProviders() as $provider)
		{
			$providerName = $provider->name();
			$output->writeln("Provider: {$providerName}");

			$progressBar = new ProgressBar(
				$output, count(Benchmarks::getBenchmarks())
					* count(self::benchCases)
				);

			$repeats = $provider->count();
			$providerReport = $this->providerReport($providerName);
			foreach ($providerReport as $result)
			{
				$result['repeats'] = $repeats;
				$result['per_second'] = $result['time']
					? $repeats / $result['time']
					: 0;

				$results[] = $result;
				$progressBar->advance();
			}

			$progressBar->finish();
			$output->writeln('');
		}

		usort($results, static function($a, $b)
		{
			return $b['per_second'] <=> $a['per_second'];
		});

		$table = new Table($output);
		$table->setHeaders([
			'Class', 'Case', 'Provider',
			'Repeats', 'Time', 'Per Second'
			]);

		foreach ($results as $data)
		{
			$table->addRow([
				str_replace(
					'Benchmark_Routing\\Benchmark\\', '',
					$data['class']
					),
				$data['case'],
				$data['provider'],
				$data['repeats'],
				sprintf('%0.6f seconds', $data['time']),
				sprintf('%0.6f', $data['per_second'])
			]);
		}

		$table->render();
	}

	/**
	* Executes all of the benchmarks against the routes of $providerName provider
	*
	* @param string $providerName
	* @return Generator
	*/
	function providerReport(string $providerName) : iterable
	{
		foreach (Benchmarks::getBenchmarks() as $benchIndex => $benchmark)
		{
			foreach (self::benchCases as $benchCase)
			{
				$time = shell_exec("php {$this->script} \
					{$benchIndex} \
					{$benchCase} \
					{$providerName}");

				yield array(
					'provider' => $providerName,
					'class' => get_class($benchmark),
					'case' => $benchCase,
					'time' => $time
					);
			}
		}
	}

	/**
	* Prints out the time spent executing $benchCase from benchmark class
	* identified by $benchIndex using the routes from $providerName provider
	*
	* @param integer $benchIndex
	* @param string $benchCase
	* @param string $providerName
	*/
	function run($benchIndex, $benchCase, $providerName)
	{
		foreach (Benchmarks::getBenchmarks() as $i => $benchmark)
		{
			if ($i == $benchIndex)
			{
				break;
			}
		}

		foreach (Providers::getProviders() as $provider)
		{
			if ($provider->name() == $providerName)
			{
				break;
			}
		}

		// benchmark case params are per provider
		//
		$params = array( 0 => $providerName );
		if ('benchLongest' == $benchCase)
		{
			foreach ($benchmark->getLongestRoute() as $name => $longest)
			{
				if ($name == $providerName)
				{
					$params = $longest;
					break;
				}
			}
		} else
		if ('benchLast' == $benchCase)
		{
			foreach ($benchmark->getLastRoute() as $name => $last)
			{
				if ($name == $providerName)
				{
					$params = $last;
					break;
				}
			}
		}

		$repeats = $provider->count();

		$start = microtime(true);
		for ($i = 0; $i < $repeats; $i++)
		{
			$benchmark->$benchCase($params);
		}

		echo microtime(true) - $start;
	}
}
