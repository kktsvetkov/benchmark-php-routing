<?php

namespace Benchmark_Routing\Benchmark\FastRoute;

use Benchmark_Routing\Benchmark\FastRoute\SimpleDispatcherAbstract;
use FastRoute\DataGenerator;
use FastRoute\Dispatcher;

class CharCountBased_Benchmark extends SimpleDispatcherAbstract
{
	protected $dataGeneratorClass = DataGenerator\CharCountBased::class;
	protected $dispatcherClass = Dispatcher\CharCountBased::class;
}
