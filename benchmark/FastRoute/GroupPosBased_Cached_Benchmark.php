<?php

namespace Benchmark_Routing\Benchmark\FastRoute;

use Benchmark_Routing\Benchmark\FastRoute\CachedDispatcherAbstract;
use FastRoute\DataGenerator;
use FastRoute\Dispatcher;

class GroupPosBased_Cached_Benchmark extends CachedDispatcherAbstract
{
	protected $dataGeneratorClass = DataGenerator\GroupPosBased::class;
	protected $dispatcherClass = Dispatcher\GroupPosBased::class;
}
