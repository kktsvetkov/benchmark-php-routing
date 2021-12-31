<?php

namespace Benchmark_Routing\Generate;

use Benchmark_Routing\Kit\Generate\GenerateAbstract;

use function join;

class FastRoute extends GenerateAbstract
{
	protected $generated = 'fastroute.php';

	function generate(array $api)
	{
		$routes = array();
		foreach ($api as $route)
		{
			$route = $this->route($route);
			$name = $this->name($route);

			/*
			* $routes->addRoute('GET', '/addon', 'addon');
			*/
			$fast[] = "\$routes->addRoute('GET', '{$route}', '{$name}');";
		}

		return '<?php '
			. "\n"
			. "\n" . join("\n", $fast)
			. "\n";
	}
}
