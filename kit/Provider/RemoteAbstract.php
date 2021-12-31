<?php

namespace Benchmark_Routing\Kit\Provider;

use Benchmark_Routing\Kit\Provider\LocalAbstract;

use function is_file;
use function md5;
use function shell_exec;

abstract class RemoteAbstract extends LocalAbstract
{
	const URL = 'https://api.somewhere.org/api.xml';

	protected function load($txt)
	{
		if (!is_file($txt))
		{
			$tmp = $this->download($txt);

			if (is_file($tmp))
			{
				$this->parse($tmp, $txt);
			}
		}

		return parent::load($txt);
	}

	protected function download($txt)
	{
		$url = static::URL;
		$tmp = '/tmp/remote.api.' . md5($url);

		shell_exec("curl -s -L {$url} -o {$tmp}");

		return $tmp;
	}

	abstract protected function parse($tmp, $txt);
}
