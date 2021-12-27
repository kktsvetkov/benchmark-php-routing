<?php

namespace Benchmark_Routing;

use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;

class Symfony_Benchmark extends Benchmark
{
	function runRouting(string $route) : array
	{
		$matcher = $this->setupRouting();
		return $matcher->match($route);
	}

	function setupRouting()
	{
		return new UrlMatcher(
			$this->loadedRoutes(),
			new RequestContext()
			);
	}

	function loadedRoutes() : RouteCollection
	{
		return include __DIR__ . '/symfony-routes.php';
	}
}
