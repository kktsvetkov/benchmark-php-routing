<?php

namespace Benchmark_Routing\Kit\Provider;

interface ProviderInterface
{
	function count() : int;
	function getRoutes() : iterable;
}
