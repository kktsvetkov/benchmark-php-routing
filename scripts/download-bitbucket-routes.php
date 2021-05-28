<?php /* Downloads the path definitions from Bitbucket API */

$txt = __DIR__ . '/../bitbucket-routes.txt';
$url = 'https://developer.atlassian.com/bitbucket/api/2/reference/resource/';

$tmp = '/tmp/download-bitbucket-routes.html';
shell_exec("curl {$url} -o {$tmp}");

$routes = [];

$html = file_get_contents($tmp);
if (preg_match('~data\: (.+),\s+context\: ~Us', $html, $R))
{
	$data = json_decode($R[1]);
	foreach ($data->paths as $path => $dummy)
	{
		$routes[] = $path;
	}
}

if ($routes)
{
	printf("%d routes found.\n", count($routes));
	file_put_contents($txt, join("\n", $routes) . "\n");
	unlink($tmp);
}
