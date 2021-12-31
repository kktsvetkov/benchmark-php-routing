<?php

namespace Benchmark_Routing;

/**
* Benchmark routing the Bitbucket API paths
*
* @Revs(182)
* @Iterations(5)
*/
abstract class Benchmark
{
	abstract function setupRouting();

	abstract function runRouting(string $route) : array;

	function benchSetup()
	{
		$this->setupRouting();
	}

	/**
	* @ParamProviders("getLastRoute")
	*/
	function benchLast(array $last)
	{
		$this->runRoute( $last['route'], $last['result'] );
	}

	function getLastRoute() : array
	{
		$routes = $this->getRoutes();
		$last = array_pop($routes);

		return array($last);
	}

	/**
	* @ParamProviders("getLongestRoute")
	*/
	function benchLongest(array $longest)
	{
		$this->runRoute( $longest['route'], $longest['result'] );
	}

	function getLongestRoute() : array
	{
		$routes = $this->getRoutes();
		usort($routes, function($a, $b)
		{
			return strlen($a['route']) <=> strlen($b['route']);
		});
		$longest = array_pop($routes);

		return array($longest);
	}

	function runRoute($route, array $result)
	{
		$match = $this->runRouting( $route );

		foreach ($result as $key => $value)
		{
			if ($match[$key] !== $value)
			{
				throw new \UnexpectedValueException(
					"Result mismatch for '{$key}': \"{$match[$key]}\" != \"{$value}\""
				);
			}
		}
	}

	function getRoutes() : array
	{
		return include __DIR__ . '/../routes/benchmark/result.php';
	}
}
