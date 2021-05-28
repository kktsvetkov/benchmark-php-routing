<?php

namespace Benchmark_Routing;

/**
* Benchmark routing the Bitbucket API paths
*
* @Warmup(2)
* @Revs(100)
* @Iterations(5)
*/
abstract class Bitbucket_Abstract
{
	abstract function runRouting(string $route) : array;

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

	/**
	* @Warmup(0)
	* @Revs(10)
	*/
	function benchAll()
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
		return array(
			['route' => '/addon', 'result' => ['_route' => 'addon']],
			['route' => '/addon/linkers', 'result' => ['_route' => 'addon_linkers']],
		);
	}
}
