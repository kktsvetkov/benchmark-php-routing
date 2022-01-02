<?php

namespace Benchmark_Routing\Kit\Provider;

use Benchmark_Routing\Kit\Provider\Register;
use Generator;

use function current;
use function next;
use function reset;
use function trim;
use function preg_match_all;
use function preg_replace;
use function str_replace;

abstract class ProviderAbstract
{
	protected $api = array();

	function __construct()
	{
		Register::addProvider($this);
	}

	function count() : int
	{
		return count($this->api);
	}

	function getRoutes() : iterable
	{
		return $this->api;
	}

	protected $resultValues = ['john', 'paul', 'george', 'ringo'];

	protected function getValue() : string
	{
		$value = current($this->resultValues);
		if (!next($this->resultValues))
		{
			reset($this->resultValues);
		}

		return $value;
	}

	function getResults() : iterable
	{
		foreach ($this->getRoutes() as $route)
		{
			$name = preg_replace('#\W+#', '_', $route);
			$name = trim($name, '_');

			$result = array('_route' => $name);

			preg_match_all('#\{(\w+)\}#', $route, $R);
			if (!empty($R[1]))
			{
				foreach ($R[1] as $i => $var)
				{
					$value = $this->getValue();
					$result[ $var ] = $value;
					$route = str_replace($R[0][$i], $value, $route);
				}
			}

			yield $name => array(
				'route' => $route,
				'result' => $result,
				);
		}
	}

	abstract function name() : string;
}
