<?php /* Quick benchmark to calculate routes matched per second */

require __DIR__ . '/config.php';

new Benchmark_Routing\Kit\Benchmark\Quick($argv);
