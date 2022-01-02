<?php

namespace Benchmark_Routing\Benchmark\FastRoute;

use Benchmark_Routing\Benchmark\FastRoute\CachedDispatcherAbstract;
use FastRoute\DataGenerator;
use FastRoute\Dispatcher;

class GroupCountBased_Cached_Benchmark extends CachedDispatcherAbstract
{
	protected $dataGeneratorClass = DataGenerator\GroupCountBased::class;
	protected $dispatcherClass = Dispatcher\GroupCountBased::class;
}
