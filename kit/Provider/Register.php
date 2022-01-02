<?php

namespace Benchmark_Routing\Kit\Provider;

use Benchmark_Routing\Kit\Provider\ProviderAbstract;

class Register
{
	static private $providers = array();

	static function addProvider(ProviderAbstract $provider)
	{
		self::$providers[ $provider->name() ] = $provider;
	}

	static function getProviders() : iterable
	{
		return self::$providers;
	}
}
