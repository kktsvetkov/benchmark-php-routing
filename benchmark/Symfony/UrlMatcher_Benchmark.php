<?php

namespace Benchmark_Routing\Benchmark\Symfony;

use Benchmark_Routing\Kit\Benchmark\BenchmarkAbstract;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

use function dirname;
use function join;
use function trim;

class UrlMatcher_Benchmark extends BenchmarkAbstract
{
	function setupRouting( $providerName )
	{
		return new UrlMatcher(
			include $this->getRoutesFilename( $providerName ),
			new RequestContext()
			);
	}

	function runRouting(string $providerName, string $route) : array
	{
		$matcher = $this->setupRouting( $providerName );
		return $matcher->match($route);
	}

	function getRoutesFilename( string $providerName ) : string
	{
		return dirname(__FILE__, 3)
			. "/routes/definition/symfony/{$providerName}.php";
	}

	function generateRoutes(array $routes) : string
	{
		$php = '';
		foreach ($routes as $route)
		{
			$name = preg_replace('#\W+#', '_', $route);
			$name = trim($name, '_');

			/*
			* $routes->add('workspaces', new Route('/workspaces'));
			*/
			$php .= "\n" . "\$routes->add('{$name}', new Route('{$route}'));";
		}

		return '<?php '
			. "\n"
			. "\n" . 'use Symfony\Component\Routing\Route;'
			. "\n" . 'use Symfony\Component\Routing\RouteCollection;'
			. "\n"
			. "\n" . '$routes = new RouteCollection();'
			. "\n" . $php
			. "\n"
			. "\n" . 'return $routes;'
			. "\n";
	}
}
