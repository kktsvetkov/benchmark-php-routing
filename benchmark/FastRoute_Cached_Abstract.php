<?php

namespace Benchmark_Routing;

use function FastRoute\cachedDispatcher;

use function get_called_class;
use function sprintf;
use function strtolower;
use function substr;

abstract class FastRoute_Cached_Abstract extends FastRoute_Abstract
{
	protected $cached_routes = __DIR__ . '/../routes/cache/fastroute-%s.php';

	function setupRouting()
	{
		$cacheFile = sprintf(
			$this->cached_routes,
			strtolower(substr(get_called_class(), 35))
			);

		return cachedDispatcher(
			[$this, 'loadRoutes'], [
			'dataGenerator' => $this->dataGeneratorClass,
	                'dispatcher' => $this->dispatcherClass,
			'cacheFile' => $cacheFile,
			]);
	}
}
