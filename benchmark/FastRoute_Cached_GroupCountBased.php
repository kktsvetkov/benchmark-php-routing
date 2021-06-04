<?php

namespace Benchmark_Routing;

use FastRoute\DataGenerator;
use FastRoute\Dispatcher;

class FastRoute_Cached_GroupCountBased extends FastRoute_Cached_Abstract
{
	protected $dataGeneratorClass = DataGenerator\GroupCountBased::class;
	protected $dispatcherClass = Dispatcher\GroupCountBased::class;
}
