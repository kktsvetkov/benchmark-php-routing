<?php

namespace Benchmark_Routing\Provider;

use Benchmark_Routing\Kit\Provider\SwaggerAbstract;

class Bitbucket extends SwaggerAbstract
{
	const LOCAL = 'bitbucket';
	const URL = 'https://api.bitbucket.org/swagger.json';
}
