<?php

namespace Benchmark_Routing;

use FastRoute\RouteCollector;
use function FastRoute\cachedDispatcher;

abstract class FastRoute_Cached_Abstract extends Benchmark
{
	protected $dataGeneratorClass;
	protected $dispatcherClass;

	protected $cached_routes = '/tmp/benchmark-fastroute-cached-routes-%s.php';

	function runRouting(string $route) : array
	{
		$dispatcher = cachedDispatcher(
			[$this, 'loadRoutes'], [
			'dataGenerator' => $this->dataGeneratorClass,
	                'dispatcher' => $this->dispatcherClass,
			'cacheFile' => \sprintf(
				$this->cached_routes,
				strtolower(substr(get_called_class(), 35))
				)
			]);

		return $dispatcher->dispatch('GET', $route)[1];
	}

	function loadRoutes(RouteCollector $routes)
	{
		include __DIR__ . '/fastroute-routes.php';
	}
}
