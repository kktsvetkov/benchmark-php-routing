<?php

namespace Benchmark_Routing;

use FastRoute\DataGenerator;
use FastRoute\Dispatcher;

class FastRoute_CharCountBased_Benchmark extends FastRoute_Abstract
{
	protected $dataGeneratorClass = DataGenerator\CharCountBased::class;
	protected $dispatcherClass = Dispatcher\CharCountBased::class;
}
