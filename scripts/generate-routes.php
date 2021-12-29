<?php /* Generates the routes for the benchmark */

require __DIR__ . '/../vendor/autoload.php';

$api = file(__DIR__ . '/../bitbucket-routes.txt');

new Benchmark_Routing\Generate\FastRoute($api);
new Benchmark_Routing\Generate\Symfony($api);
new Benchmark_Routing\Generate\Results($api);
