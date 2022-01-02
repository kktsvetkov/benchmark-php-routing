<?php

namespace Benchmark_Routing\Benchmark\FastRoute;

use Benchmark_Routing\Benchmark\FastRoute\SimpleDispatcherAbstract;
use FastRoute\DataGenerator;
use FastRoute\Dispatcher;

class MarkBased_Benchmark extends SimpleDispatcherAbstract
{
	protected $dataGeneratorClass = DataGenerator\MarkBased::class;
	protected $dispatcherClass = Dispatcher\MarkBased::class;
}
