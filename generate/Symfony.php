<?php

namespace Benchmark_Routing\Generate;

use function join;

class Symfony extends GenerateAbstract
{
	protected $generated = 'symfony.php';

	function generate(array $api)
	{
		$routes = array();
		foreach ($api as $route)
		{
			$route = $this->route($route);
			$name = $this->name($route);

			/*
			* $routes->add('workspaces', new Route('/workspaces'));
			*/
			$routes[] = "\$routes->add('{$name}', new Route('{$route}'));";
		}

		return '<?php '
			. "\n"
			. "\n" . 'use Symfony\Component\Routing\Route;'
			. "\n" . 'use Symfony\Component\Routing\RouteCollection;'
			. "\n"
			. "\n" . '$routes = new RouteCollection();'
			. "\n"
			. "\n" . join("\n", $routes)
			. "\n"
			. "\n" . 'return $routes;'
			. "\n";
	}
}
