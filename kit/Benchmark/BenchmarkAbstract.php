<?php

namespace Benchmark_Routing\Kit\Benchmark;

use Benchmark_Routing\Kit\Benchmark\Register as Benchmarks;
use Benchmark_Routing\Kit\Provider\Register as Providers;
use Benchmark_Routing\Kit\Provider\ProviderAbstract;
use UnexpectedValueException;
use Generator;

use function current;
use function dirname;
use function file_put_contents;
use function is_dir;
use function is_file;
use function mkdir;
use function next;
use function print_r;
use function strlen;
use function reset;

/**
* Benchmark routing the provider routes
*
* @Revs(200)
* @Iterations(5)
*/
abstract class BenchmarkAbstract
{
	/**
	* Setup the routing for the $providerName provider
	*
	* @param string $providerName
	*/
	abstract function setupRouting(string $providerName);

	/**
	* Execute the routing for $route from the $providerName provider
	*
	* @param string $providerName
	* @param string $route
	*/
	abstract function runRouting(string $providerName, string $route) : array;

	/**
	* Return the filename where the routes for $providerName should be stored
	*
	* @param string $providerName
	* @return string
	*/
	abstract function getRoutesFilename( string $providerName ) : string;

	/**
	* Generate the PHP code for the route definition of $routes
	*
	* @param array $routes
	* @return string
	*/
	abstract function generateRoutes(array $routes) : string;

	/**
	* Constructor: processes all of the providers and registers the benchmark
	*/
	function __construct()
	{
		foreach (Providers::getProviders() as $provider)
		{
			$this->buildRoutes($provider);
			$this->setupProvider($provider);
		}

		Benchmarks::addBenchmark($this);
	}

	/**
	* Build the routes declaration from the routes in $provider
	*
	* @param ProviderAbstract $provider
	*/
	function buildRoutes(ProviderAbstract $provider)
	{
		$filename = $this->getRoutesFilename(
			$providerName = $provider->name()
			);

		if (is_file($filename))
		{
			return;
		}

		$this->writeFile(
			$filename,
			$this->generateRoutes( $provider->getRoutes() )
			);
	}

	/**
	* Shortcut method for writing files that does the extra folder check
	*
	* @param string $filename
	* @param string $contents
	*/
	protected function writeFile(string $filename, string $contents)
	{
		$this->checkFile($filename);
		file_put_contents( $filename, $contents );
	}

	/**
	* Shortcut method for extra folder check
	*
	* @param string $filename
	*/
	protected function checkFile(string $filename)
	{
		$dir = dirname($filename);
		if (!is_dir($dir))
		{
			mkdir($dir, 02777, true);
		}
	}

	/**
	* @var array list of provider names (key and value are the same)
	*/
	protected $providerNames = array();

	/**
	* @var array list of last routes per provider
	*/
	protected $lastRoute = array();

	/**
	* @var array list of longest routes per provider
	*/
	protected $longestRoute = array();

	/**
	* Setup the benchmark with the details from $provider
	*
	* This method will extract the provider name, find the longest route
	* and the last route.
	*
	* @param ProviderAbstract $provider
	*/
	protected function setupProvider(ProviderAbstract $provider)
	{
		$this->providerNames[$name = $provider->name()] = [$name];

		$longest = null;
		foreach ($provider->getResults() as $route)
		{
			if (!$longest)
			{
				$longest = $route;
				continue;
			}

			if (strlen($route['route']) > strlen($longest['route']))
			{
				$longest = $route;
			}
		}

		$this->lastRoute[ $name ] = array(
			$name,
			$route['route'],
			$route['result']
		);

		$this->longestRoute[ $name ] = array(
			$name,
			$longest['route'],
			$longest['result']
		);
	}

	/**
	* Do the actual benchmark for $route and compare the output with $result
	*
	* @param string $providerName
	* @param string $route
	* @param array $result
	* @throws UnexpectedValueException
	*/
	function doBenchmark(string $providerName, string $route, array $result)
	{
		$match = $this->runRouting( $providerName, $route );

		if ($match != $result)
		{
			throw new UnexpectedValueException(
				'Result mismatch: '
					. print_r($match, true)
					. ' != '
					. print_r($result, true)
			);
		}
	}

	/**
	* @ParamProviders("getProviderName")
	*/
	function benchSetup(array $provider)
	{
		$this->setupRouting( $provider[0] );
	}

	function getProviderName() : Generator
	{
		yield from $this->providerNames;
	}

	/**
	* @ParamProviders("getLastRoute")
	*/
	function benchLast(array $last)
	{
		$this->doBenchmark( ...$last );
	}

	function getLastRoute() : Generator
	{
		yield from $this->lastRoute;
	}

	/**
	* @ParamProviders("getLongestRoute")
	*/
	function benchLongest(array $longest)
	{
		$this->doBenchmark(...$longest );
	}

	function getLongestRoute() : Generator
	{
		yield from $this->longestRoute;
	}

	/**
	* @ParamProviders("getProviderName")
	*/
	function benchAll(array $provider)
	{
		$next = $this->getNextRoute( $provider[0] );
		$this->doBenchmark( $provider[0], $next['route'], $next['result'] );
	}

	/**
	* Cycle over all of the routes from the $name provider
	*
	* @param string $providerName the name of the provider
	* @return array next route from the list of results
	*/
	function getNextRoute( $providerName )
	{
		static $routes;
		if (empty($routes[ $providerName ]))
		{
			foreach (Providers::getProviders() as $provider)
			{
				$routes[ $provider->name() ] = $provider->getResults();
			}
		}

		$route = $routes[ $providerName ]->current();
		if (!$routes[ $providerName ]->next())
		{
			$routes[ $providerName ] = null;
		}

		return $route;
	}
}
