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
		$dispatcher = simpleDispatcher(
			[$this, 'loadRoutes'], [
			'dataGenerator' => $this->dataGeneratorClass,
	                'dispatcher' => $this->dispatcherClass
			]);

		return $dispatcher->dispatch('GET', $route)[1];
	}

	function loadRoutes(RouteCollector $routes)
	{
		include __DIR__ . '/fastroute-routes.php';
	}
}
