<?php

namespace Benchmark_Routing\Kit\Provider;

use Benchmark_Routing\Kit\Provider\RemoteAbstract;

use function file_get_contents;
use function file_put_contents;
use function is_file;
use function join;
use function json_decode;

abstract class SwaggerAbstract extends RemoteAbstract
{
	const URL = 'https://api.somewhere.org/swagger.json';

	protected function parse($tmp, $txt)
	{
		if (!is_file($tmp))
		{
			return false;
		}

		$routes = [];

		$json = file_get_contents($tmp);
		$data = json_decode($json);

		foreach ($data->paths as $path => $dummy)
		{
			$routes[] = $path;
		}

		if (!$routes)
		{
			return false;
		}

		file_put_contents($txt, join("\n", $this->api = $routes));
		return true;
	}
}
