<?php

namespace Benchmark_Routing;

use FastRoute\DataGenerator;
use FastRoute\Dispatcher;

class FastRoute_Cached_GroupPosBased extends FastRoute_Cached_Abstract
{
	protected $dataGeneratorClass = DataGenerator\GroupPosBased::class;
	protected $dispatcherClass = Dispatcher\GroupPosBased::class;
}
