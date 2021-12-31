<?php /* Generates the routes for the benchmark */

require __DIR__ . '/../vendor/autoload.php';

$provider = new Benchmark_Routing\Provider\Bitbucket;
$api = $provider->getRoutes();

new Benchmark_Routing\Generate\FastRoute($api);
new Benchmark_Routing\Generate\Symfony($api);

new Benchmark_Routing\Generate\Results($api);
