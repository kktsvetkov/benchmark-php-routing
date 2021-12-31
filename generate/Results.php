<?php

namespace Benchmark_Routing\Generate;

use Benchmark_Routing\Kit\Generate\GenerateAbstract;

use function current;
use function join;
use function next;
use function reset;
use function str_replace;

class Results extends GenerateAbstract
{
	protected $generated = 'result.php';

	protected $vars = ['john', 'paul', 'george', 'ringo'];

	function generate(array $api)
	{
		$routes = array();
		foreach ($api as $route)
		{
			$route = $this->route($route);
			$name = $this->name($route);

			$result = "['_route' => '{$name}'";

			preg_match_all('#\{(\w+)\}#', $route, $R);
			if (!empty($R[1]))
			{
				foreach ($R[1] as $i => $var)
				{
					$value = current($this->vars);
					if (!next($this->vars))
					{
						reset($this->vars);
					}

					$result .= ", '{$var}' => '{$value}'";
					$route = str_replace($R[0][$i], $value, $route);
				}
			}

			/*
			* ['route' => '/workspaces', 'result' => ['_route' => 'workspaces']]
			*/
			$routes[] = "['route' => '{$route}', 'result' => {$result}]]";
		}

		return '<?php '
			. "\n"
			. "\n" . 'return array('
			. "\n" . "\t" . join(",\n\t", $routes)
			. "\n" . ');'
			. "\n";
	}
}
