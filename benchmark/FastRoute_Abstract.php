<?php

namespace Benchmark_Routing;

use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

abstract class FastRoute_Abstract extends Benchmark
{
	protected $dataGeneratorClass;
	protected $dispatcherClass;

	function runRouting(string $route) : array
	{
		$dispatcher = $this->setupRouting();

		$match = $dispatcher->dispatch('GET', $route);
		return $match[1] + $match[2];
	}

	function setupRouting()
	{
		return simpleDispatcher(
			[$this, 'loadRoutes'], [
			'dataGenerator' => $this->dataGeneratorClass,
	                'dispatcher' => $this->dispatcherClass
			]);
	}

	function loadRoutes(RouteCollector $routes)
	{
		include __DIR__ . '/fastroute-routes.php';
	}
}
