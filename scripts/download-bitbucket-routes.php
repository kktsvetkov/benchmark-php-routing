<?php /* Downloads the path definitions from Bitbucket API */

$txt = __DIR__ . '/../bitbucket-routes.txt';
$url = 'https://api.bitbucket.org/swagger.json';

$tmp = '/tmp/api.bitbucket.org.swagger.json';
shell_exec("curl -s -L {$url} -o {$tmp}");

$routes = [];

$json = file_get_contents($tmp);
$data = json_decode($json);

foreach ($data->paths as $path => $dummy)
{
	$routes[] = $path;
}

if ($routes)
{
	printf("%d routes found.\n", count($routes));
	file_put_contents($txt, join("\n", $routes) . "\n");
	unlink($tmp);
}
