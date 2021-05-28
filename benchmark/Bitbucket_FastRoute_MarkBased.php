<?php

namespace Benchmark_Routing;

use FastRoute\DataGenerator;
use FastRoute\Dispatcher;

class Bitbucket_FastRoute_MarkBased extends Bitbucket_FastRoute_Abstract
{
	protected $dataGeneratorClass = DataGenerator\MarkBased::class;
	protected $dispatcherClass = Dispatcher\MarkBased::class;
}
