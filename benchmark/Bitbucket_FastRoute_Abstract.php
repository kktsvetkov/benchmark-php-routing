<?php

namespace Benchmark_Routing;

use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

abstract class Bitbucket_FastRoute_Abstract extends Bitbucket_Abstract
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
		// $routes->addRoute('GET', '/addon', ['_route' => 'addon']);
		// $routes->addRoute('GET', '/addon/linkers', ['_route' => 'addon_linkers']);
	}
}
