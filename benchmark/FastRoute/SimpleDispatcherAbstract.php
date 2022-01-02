<?php

namespace Benchmark_Routing\Benchmark\FastRoute;

use Benchmark_Routing\Kit\Benchmark\BenchmarkAbstract;
use Benchmark_Routing\Kit\Provider\ProviderAbstract;
use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

abstract class SimpleDispatcherAbstract extends BenchmarkAbstract
{
	protected $dataGeneratorClass;
	protected $dispatcherClass;

	function runRouting(string $providerName, string $route) : array
	{
		$dispatcher = $this->setupRouting($providerName);

		$match = $dispatcher->dispatch('GET', $route);
		return array('_route' => $match[1]) + $match[2];
	}

	protected $loadRoutes = array();

	protected function setupProvider(ProviderAbstract $provider)
	{
		parent::setupProvider($provider);

		$this->loadRoutes[ $providerName = $provider->name() ] =
		function(RouteCollector $routes) use ($providerName)
		{
			include $this->getRoutesFilename( $providerName );
		};
	}

	function setupRouting( $providerName )
	{
		return simpleDispatcher(
			$this->loadRoutes[ $providerName ], [
			'dataGenerator' => $this->dataGeneratorClass,
	                'dispatcher' => $this->dispatcherClass
			]);
	}

	function getRoutesFilename( string $providerName ) : string
	{
		return dirname(__FILE__, 3)
			. "/routes/definition/fastroute/{$providerName}.php";
	}

	function generateRoutes(array $routes) : string
	{
		$php = '';
		foreach ($routes as $route)
		{
			$name = preg_replace('#\W+#', '_', $route);
			$name = trim($name, '_');

			/*
			* $routes->addRoute('GET', '/addon', 'addon');
			*/
			$php .= "\n" . "\$routes->addRoute('GET', '{$route}', '{$name}');";
		}

		return '<?php '
			. "\n" . $php
			. "\n";
	}
}
