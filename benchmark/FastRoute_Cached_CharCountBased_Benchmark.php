<?php

namespace Benchmark_Routing;

use FastRoute\DataGenerator;
use FastRoute\Dispatcher;

class FastRoute_Cached_CharCountBased_Benchmark extends FastRoute_Cached_Abstract
{
	protected $dataGeneratorClass = DataGenerator\CharCountBased::class;
	protected $dispatcherClass = Dispatcher\CharCountBased::class;
}
