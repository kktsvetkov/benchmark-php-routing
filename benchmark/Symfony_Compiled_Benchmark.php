<?php

namespace Benchmark_Routing;

use Symfony\Component\Routing\Matcher\CompiledUrlMatcher;
use Symfony\Component\Routing\Matcher\Dumper\CompiledUrlMatcherDumper;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;

use function file_put_contents;

class Symfony_Compiled_Benchmark extends Benchmark
{
	protected $cached_routes = '/tmp/benchmark-symfony-compiled-routes.php';

	function __construct()
	{
		$dumper = new CompiledUrlMatcherDumper( $this->loadedRoutes() );
		$compiled = $dumper->getCompiledRoutes();

		file_put_contents(
			$this->cached_routes,
			'<?php return ' . \var_export($compiled, true) . ';'
			);
	}

	function setupRouting()
	{
		return new CompiledUrlMatcher(
			include $this->cached_routes,
			new RequestContext()
			);
	}

	function runRouting(string $route) : array
	{
		$matcher = $this->setupRouting();
		return $matcher->match($route);
	}

	function loadedRoutes() : RouteCollection
	{
		return include __DIR__ . '/symfony-routes.php';
	}
}
