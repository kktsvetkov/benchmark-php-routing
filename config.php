<?php

require __DIR__ . '/vendor/autoload.php';

use Benchmark_Routing\Benchmark;
use Benchmark_Routing\Provider;

/*
|--------------------------------------------------------------------------
| Route Providers
|--------------------------------------------------------------------------
*/

new Provider\Bitbucket;
new Provider\Avatax;

/*
|--------------------------------------------------------------------------
| Symfony Benchmarks
|--------------------------------------------------------------------------
*/

new Benchmark\Symfony\UrlMatcher_Benchmark;
new Benchmark\Symfony\CompiledUrlMatcher_Benchmark;

/*
|--------------------------------------------------------------------------
| FastRoute Benchmarks
|--------------------------------------------------------------------------
*/

new Benchmark\FastRoute\CharCountBased_Benchmark;
new Benchmark\FastRoute\CharCountBased_Cached_Benchmark;

new Benchmark\FastRoute\GroupCountBased_Benchmark;
new Benchmark\FastRoute\GroupCountBased_Cached_Benchmark;

new Benchmark\FastRoute\GroupPosBased_Benchmark;
new Benchmark\FastRoute\GroupPosBased_Cached_Benchmark;

new Benchmark\FastRoute\MarkBased_Benchmark;
new Benchmark\FastRoute\MarkBased_Cached_Benchmark;
