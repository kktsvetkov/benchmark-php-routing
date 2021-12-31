<?php

namespace Benchmark_Routing\Kit\Provider;

use Benchmark_Routing\Kit\Provider\ProviderInterface;

use function array_map;
use function count;
use function dirname;
use function file;
use function is_file;
use function join;
use function sort;

use const DIRECTORY_SEPARATOR;

abstract class LocalAbstract implements ProviderInterface
{
	const LOCAL = 'routes';

	protected $api = array();

	function __construct()
	{
		$txt = dirname(__FILE__, 3)
			. DIRECTORY_SEPARATOR . 'routes'
			. DIRECTORY_SEPARATOR . 'provider'
			. DIRECTORY_SEPARATOR . static::LOCAL;
		$this->load($txt);
	}

	protected function load($txt)
	{
		if (!is_file($txt))
		{
			return false;
		}

		$lines = file($txt);
		$this->api = array_map('trim', $lines);
		sort($this->api);

		return true;
	}

	function count() : int
	{
		return count($this->api);
	}

	function getRoutes() : iterable
	{
		return $this->api;
	}
}
