<?php /* Generates the routes for the benchmark */

$txt = __DIR__ . '/../bitbucket-routes.txt';
$symfony_routes = __DIR__ . '/../benchmark/symfony-routes.php';
$result_routes = __DIR__ . '/../benchmark/result-routes.php';

$vars = ['john', 'paul', 'george', 'ringo'];

$routes = [];
$symfony = [];

$fp = fopen($txt, 'r');
while ($r = fgets($fp))
{
	$r = rtrim($r);

	$name = preg_replace('#\W+#', '_', $r);
	$name = trim($name, '_');

	/*
	* $routes->add('workspaces', new Route('/workspaces'));
	*/
	$symfony[] = "\$routes->add('{$name}', new Route('{$r}'));";

	$m = $r;
	$result = "['_route' => '{$name}'";

	preg_match_all('#\{(\w+)\}#', $r, $R);
	if (!empty($R[1]))
	{
		foreach ($R[1] as $i => $var)
		{
			$value = current($vars);
			if (!next($vars))
			{
				reset($vars);
			}

			$result .= ", '{$var}' => '{$value}'";
			$m = str_replace($R[0][$i], $value, $m);
		}
	}

	/*
	* ['route' => '/workspaces', 'result' => ['_route' => 'workspaces']]
	*/
	$routes[] = "['route' => '{$m}', 'result' => {$result}]]";
}

fclose($fp);

file_put_contents($symfony_routes, '<?php '
	. "\n"
	. "\n" . 'use Symfony\Component\Routing\Route;'
	. "\n" . 'use Symfony\Component\Routing\RouteCollection;'
	. "\n"
	. "\n" . '$routes = new RouteCollection();'
	. "\n"
	. "\n" . join("\n", $symfony)
	. "\n"
	. "\n" . 'return $routes;'
	. "\n"
	);
printf("%s done.\n", basename($symfony_routes));

file_put_contents($result_routes, '<?php '
	. "\n"
	. "\n" . 'return array('
	. "\n" . "\t" . join(",\n\t", $routes)
	. "\n" . ');'
	. "\n"
	);
printf("%s done.\n", basename($result_routes));
