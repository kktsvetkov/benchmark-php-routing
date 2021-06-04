<?php

namespace Benchmark_Routing;

use FastRoute\DataGenerator;
use FastRoute\Dispatcher;

class FastRoute_Cached_MarkBased extends FastRoute_Cached_Abstract
{
	protected $dataGeneratorClass = DataGenerator\MarkBased::class;
	protected $dispatcherClass = Dispatcher\MarkBased::class;
}
