<?php

namespace Benchmark_Routing\Benchmark\FastRoute;

use Benchmark_Routing\Benchmark\FastRoute\SimpleDispatcherAbstract;
use FastRoute\DataGenerator;
use FastRoute\Dispatcher;

class GroupCountBased_Benchmark extends SimpleDispatcherAbstract
{
	protected $dataGeneratorClass = DataGenerator\GroupCountBased::class;
	protected $dispatcherClass = Dispatcher\GroupCountBased::class;
}
