<?php

namespace Benchmark_Routing;

use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class Bitbucket_Symfony extends Bitbucket_Abstract
{
	function runRouting(string $route) : array
	{
		$matcher = new UrlMatcher(
			$this->loadedRoutes(),
			new RequestContext()
			);

		return $matcher->match($route);
	}

	function loadedRoutes() : RouteCollection
	{
		$routes = new RouteCollection();

		$routes->add('addon', new Route('/addon'));
		$routes->add('addon_linkers', new Route('/addon/linkers'));

		return $routes;
	}
}
