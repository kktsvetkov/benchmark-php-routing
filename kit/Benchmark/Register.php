<?php

namespace Benchmark_Routing\Kit\Benchmark;

use Benchmark_Routing\Kit\Benchmark\BenchmarkAbstract;

class Register
{
	static private $benchmarks = array();

	static function addBenchmark(BenchmarkAbstract $benchmark)
	{
		self::$benchmarks[] = $benchmark;
	}

	static function getBenchmarks() : iterable
	{
		return self::$benchmarks;
	}
}
