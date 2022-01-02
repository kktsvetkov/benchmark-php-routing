<?php

namespace Benchmark_Routing\Benchmark\FastRoute;

use Benchmark_Routing\Benchmark\FastRoute\CachedDispatcherAbstract;
use FastRoute\DataGenerator;
use FastRoute\Dispatcher;

class MarkBased_Cached_Benchmark extends CachedDispatcherAbstract
{
	protected $dataGeneratorClass = DataGenerator\MarkBased::class;
	protected $dispatcherClass = Dispatcher\MarkBased::class;
}
