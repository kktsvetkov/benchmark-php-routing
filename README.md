# Benchmark PHP Routing

Take a real world routing scenario in the form of [Bitbucket API](https://developer.atlassian.com/bitbucket/api/2/reference/resource/) and benchmark PHP routing packages against it.

To run the benchmarks, first you have to run `composer update` to get all of the
packages and their dependencies. After that, you can execute any of benchmark
files like this:
```sh
php vendor/bin/phpbench run benchmark/Symfony.php --report=aggregate
```
Or you can run all of the benchmarks at once
```sh
php vendor/bin/phpbench run --report=aggregate
```

# Packages

* Symfony Routing [symfony/routing](https://github.com/symfony/routing)
* Fast Route [nikic/fast-route](https://github.com/nikic/fast-route)

# Benchmarks

This is the list of the available benchmarks

| Package | File | Strategy |
|---------|------|----------|
| [symfony/routing](https://github.com/symfony/routing) | benchmark/Symfony.php | `Symfony\Component\Routing\Matcher\UrlMatcher` |
| [symfony/routing](https://github.com/symfony/routing) | benchmark/Symfony_Compiled.php | `Symfony\Component\Routing\Matcher\CompiledUrlMatcher` |
| [nikic/fast-route](https://github.com/nikic/fast-route) | benchmark/FastRoute_GroupCountBased.php | `FastRoute\Dispatcher\GroupCountBased` |
| [nikic/fast-route](https://github.com/nikic/fast-route) | benchmark/FastRoute_GroupPosBased.php | `FastRoute\Dispatcher\GroupPosBased` |
| [nikic/fast-route](https://github.com/nikic/fast-route) | benchmark/FastRoute_CharCountBased.php | `FastRoute\Dispatcher\CharCountBased` |
| [nikic/fast-route](https://github.com/nikic/fast-route) | benchmark/FastRoute_MarkBased.php | `FastRoute\Dispatcher\MarkBased` |

The benchmark cases are:

* **benchLast** -- match the last route in the list of routing definitions, as this is considered the worst case
* **benchLongest** -- match the longest route to test the complexity of parsing bigger paths
* **benchAll** -- match all of the routes from the list of routing definitions to average the overall performance

# Routes

All the routes for this benchmark are read from this address:
https://developer.atlassian.com/bitbucket/api/2/reference/resource/

Only the paths are used, and the HTTP verbs/methods are ignored.

You can see the list of paths in [bitbucket-routes.txt](bitbucket-routes.txt):

```
/addon
/addon/linkers
/addon/linkers/{linker_key}
/addon/linkers/{linker_key}/values
/addon/linkers/{linker_key}/values/{value_id}
/hook_events
/hook_events/{subject_type}
/pullrequests/{selected_user}
/repositories
/repositories/{workspace}
/repositories/{workspace}/{repo_slug}
...
```

# Scripts

There are a few scripts to assist with some of the grunt work:

* [scripts/download-bitbucket-routes.php](scripts/download-bitbucket-routes.php):
	downloads the path definitions from [Bitbucket API](https://developer.atlassian.com/bitbucket/api/2/reference/resource/) page
* [scripts/generate-routes.php](scripts/generate-routes.php):
	generates the routes definitions for the packages, as well as the expected results
* [scripts/quick-benchmark.php](scripts/quick-benchmark.php):
	runs the benchmark cases to calculate number of matches per second (more is better)

# Quick Benchmark

In addition to the phpbench cases, I've also created a script that will run all
of the scenarios against all of the packages and strategies, and calculate the
number of routes matched per second. The results are then sorted by that data.

Here's the inaugural run of that script, and as you can see
Symfony's Compiled URL Matching is 3x to 10x faster than the
rest.

```
~/github.benchmark-php-routing/php scripts/quick-benchmark.php
 18/18 [============================] 100%
+------------------+--------------+--------+-------------------+-----------------+
| Case             | Scenario     | Routes | Time              | Per Second      |
+------------------+--------------+--------+-------------------+-----------------+
| symfony_compiled | benchAll     | 364    | 0.817477 seconds  | 445.27247300544 |
| symfony_compiled | benchLast    | 200    | 1.970871 seconds  | 101.47797743936 |
| symfony_compiled | benchLongest | 200    | 1.978635 seconds  | 101.07979326656 |
| fast_mark        | benchAll     | 364    | 8.570551 seconds  | 42.471014212756 |
| fast_char_count  | benchAll     | 364    | 8.647037 seconds  | 42.095344193395 |
| fast_group_pos   | benchAll     | 364    | 8.709944 seconds  | 41.791313421905 |
| fast_group_count | benchAll     | 364    | 8.883532 seconds  | 40.974693180939 |
| symfony          | benchAll     | 364    | 10.287461 seconds | 35.382880041987 |
| fast_mark        | benchLast    | 200    | 6.180378 seconds  | 32.360480424948 |
| fast_group_pos   | benchLast    | 200    | 6.241153 seconds  | 32.045360840023 |
| fast_group_pos   | benchLongest | 200    | 6.244522 seconds  | 32.028071478664 |
| fast_char_count  | benchLongest | 200    | 6.324598 seconds  | 31.622562835016 |
| fast_mark        | benchLongest | 200    | 6.424930 seconds  | 31.128743351575 |
| fast_group_count | benchLongest | 200    | 6.459257 seconds  | 30.963312979051 |
| fast_group_count | benchLast    | 200    | 6.541316 seconds  | 30.574887225916 |
| symfony          | benchLongest | 200    | 6.764358 seconds  | 29.566737702055 |
| symfony          | benchLast    | 200    | 7.047871 seconds  | 28.377364393312 |
| fast_char_count  | benchLast    | 200    | 7.467640 seconds  | 26.782223307453 |
+------------------+--------------+--------+-------------------+-----------------+
```
