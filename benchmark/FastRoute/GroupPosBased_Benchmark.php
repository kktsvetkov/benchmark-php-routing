<?php

namespace Benchmark_Routing\Benchmark\FastRoute;

use Benchmark_Routing\Benchmark\FastRoute\SimpleDispatcherAbstract;
use FastRoute\DataGenerator;
use FastRoute\Dispatcher;

class GroupPosBased_Benchmark extends SimpleDispatcherAbstract
{
	protected $dataGeneratorClass = DataGenerator\GroupPosBased::class;
	protected $dispatcherClass = Dispatcher\GroupPosBased::class;
}
