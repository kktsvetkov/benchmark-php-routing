<?php

namespace Benchmark_Routing\Benchmark\FastRoute;

use Benchmark_Routing\Benchmark\FastRoute\CachedDispatcherAbstract;
use FastRoute\DataGenerator;
use FastRoute\Dispatcher;

class CharCountBased_Cached_Benchmark extends CachedDispatcherAbstract
{
	protected $dataGeneratorClass = DataGenerator\CharCountBased::class;
	protected $dispatcherClass = Dispatcher\CharCountBased::class;
}
