<?php /* Quick and dirty script to calculate routes matched per second */

require __DIR__ . '/../vendor/autoload.php';

new quick_benchmark($argv[1] ?? '', $argv[2] ?? '');

class quick_benchmark
{
	const benchmark = array(
		'symfony_compiled' => \Benchmark_Routing\Symfony_Compiled_Benchmark::class,
		'symfony' => \Benchmark_Routing\Symfony_Benchmark::class,

		'fast_mark' => \Benchmark_Routing\FastRoute_MarkBased_Benchmark::class,
		'fast_group_pos' => \Benchmark_Routing\FastRoute_GroupPosBased_Benchmark::class,
		'fast_char_count' => \Benchmark_Routing\FastRoute_CharCountBased_Benchmark::class,
		'fast_group_count' => \Benchmark_Routing\FastRoute_GroupCountBased_Benchmark::class,

		'fast_cached_mark' => \Benchmark_Routing\FastRoute_Cached_MarkBased_Benchmark::class,
		'fast_cached_group_pos' => \Benchmark_Routing\FastRoute_Cached_GroupPosBased_Benchmark::class,
		'fast_cached_char_count' => \Benchmark_Routing\FastRoute_Cached_CharCountBased_Benchmark::class,
		'fast_cached_group_count' => \Benchmark_Routing\FastRoute_Cached_GroupCountBased_Benchmark::class,
		);

	const scenario = array(
		'benchAll' => [0, 2], /* 0 will be replaced with the total number of routes */
		'benchLongest' => [2, 0],
		'benchLast' => [2, 0],
		'benchSetup' => [2, 0],
		);

	/**
	* @var int total number of routes
	*/
	protected $total = 0;

	function __construct($case, $scenario)
	{
		$provider = new Benchmark_Routing\Provider\Bitbucket;
		$this->total = $provider->count();

		('' === $case)
			? $this->all()
			: $this->run($case, $scenario);
	}

	function all()
	{
		$output = new \Symfony\Component\Console\Output\ConsoleOutput();
		$progressBar = new Symfony\Component\Console\Helper\ProgressBar(
			$output, count(self::benchmark) * count(self::scenario)
			);

		$result = [];
		foreach (self::benchmark as $case => $class)
		{
			foreach (self::scenario as $scenario => $revs)
			{
				$time = shell_exec("php " . __FILE__ . " {$case} {$scenario}");
				$progressBar->advance();

				$revs[0] = $revs[0] ?: $this->total;
				$revs[1] = $revs[1] ?: $this->total;

				$result[] = array(
					'case' => $case,
					'scenario' => $scenario,
					'time' => $time,
					'repeats' => $revs[0] * $revs[1],
					'per_second' =>$time
						? $revs[0] * $revs[1] / $time
						: 0,
					);
			}
		}

		$progressBar->finish();
		$output->writeln('');

		usort($result, static function($a, $b)
		{
			return $b['per_second'] <=> $a['per_second'];
		});

		$table = new \Symfony\Component\Console\Helper\Table($output);
		$table->setHeaders(['Case', 'Scenario', 'Routes', 'Time', 'Per Second']);

		foreach ($result as $data)
		{
			$table->addRow([
				$data['case'],
				$data['scenario'],
				$data['repeats'],
				sprintf('%0.6f seconds', $data['time']),
				sprintf('%0.6f', $data['per_second'])
			]);

		}
		$table->render();
	}

	function run($case, $scenario)
	{
		$class = self::benchmark[ $case ];
		$bench = new $class;
		$repeats = self::scenario[ $scenario ][1] ?: $this->total;

		$start = microtime(true);
		for ($i = 0; $i < $repeats; $i++)
		{
			$this->$scenario($bench);

		}

		echo microtime(true) - $start;
	}

	function benchAll($bench)
	{
		$routes = $bench->getRoutes();
		foreach ($routes as $route)
		{
			$bench->runRouting( $route['route'] );
		}
	}

	function benchSetup($bench)
	{
		$bench->benchSetup();
	}

	function benchLongest($bench)
	{
		$bench->runRouting( $bench->getLongestRoute()[0]['route'] );
	}

	function benchLast($bench)
	{
		$bench->runRouting( $bench->getLastRoute()[0]['route'] );
	}
}
