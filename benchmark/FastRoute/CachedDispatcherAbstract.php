<?php

namespace Benchmark_Routing\Benchmark\FastRoute;

use Benchmark_Routing\Benchmark\FastRoute\SimpleDispatcherAbstract;
use Benchmark_Routing\Kit\Provider\ProviderAbstract;
use function FastRoute\cachedDispatcher;

use function dirname;
use function get_called_class;
use function strtolower;
use function substr;

abstract class CachedDispatcherAbstract extends SimpleDispatcherAbstract
{
	protected $cachedRoutes = array();

	protected function setupProvider(ProviderAbstract $provider)
	{
		parent::setupProvider($provider);

		$strategy = substr(get_called_class(), 38, -17);
		$strategy = strtolower($strategy);

		$cacheFile =
		$this->cachedRoutes[ $providerName = $provider->name() ] =
			dirname(__FILE__, 3)
				. "/routes/cache/fastroute/"
				. "{$strategy}/{$providerName}.php";

		$this->checkFile($cacheFile, '');
	}

	function setupRouting( $providerName )
	{
		return cachedDispatcher(
			$this->loadRoutes[ $providerName ], [
			'dataGenerator' => $this->dataGeneratorClass,
	                'dispatcher' => $this->dispatcherClass,
			'cacheFile' => $this->cachedRoutes[ $providerName ]
			]);
	}
}
