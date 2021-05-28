<?php

namespace Benchmark_Routing;

/**
* Benchmark routing the Bitbucket API paths
*/
abstract class Benchmark
{
	abstract function runRouting(string $route) : array;

	/**
	* @ParamProviders("getLastRoute")
	* @Revs(100)
	* @Iterations(5)
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
	* @Revs(100)
	* @Iterations(5)
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

	/**
	* @Revs(10)
	* @Iterations(1)
	*/
	function XbenchAll()
	{
		$routes = $this->getRoutes();
		foreach ($routes as $params)
		{
			$this->runRoute( $params['route'], $params['result'] );
		}
	}

	function runRoute($route, array $result)
	{
		$match = $this->runRouting( $route );
		\assert($match['_route'] === $result['_route']);
	}

	function getRoutes() : array
	{
		return include __DIR__ . '/result-routes.php';
	}
}
