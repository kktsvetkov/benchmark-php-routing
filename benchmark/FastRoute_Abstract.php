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
		return $dispatcher->dispatch('GET', $route)[1];
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
