<?php

namespace Benchmark_Routing;

use FastRoute\DataGenerator;
use FastRoute\Dispatcher;

class FastRoute_GroupPosBased_Benchmark extends FastRoute_Abstract
{
	protected $dataGeneratorClass = DataGenerator\GroupPosBased::class;
	protected $dispatcherClass = Dispatcher\GroupPosBased::class;
}
