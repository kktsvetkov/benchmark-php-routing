<?php

namespace Benchmark_Routing;

use FastRoute\DataGenerator;
use FastRoute\Dispatcher;

class FastRoute_GroupCountBased_Benchmark extends FastRoute_Abstract
{
	protected $dataGeneratorClass = DataGenerator\GroupCountBased::class;
	protected $dispatcherClass = Dispatcher\GroupCountBased::class;
}
