# Benchmark PHP Routing

Take a real world routing scenario in the form of [Bitbucket API](https://developer.atlassian.com/bitbucket/api/2/reference/resource/) and benchmark PHP routing packages against it.

You can read more about this here:

-  http://kaloyan.info/writing/2021/05/31/benchmark-php-routing.html
-  http://kaloyan.info/writing/2021/06/07/more-php-routing-benchmarks.html

# Packages
Here are the packages that are benchmakred:

* Symfony Routing [symfony/routing](https://github.com/symfony/routing)
* FastRoute [nikic/FastRoute](https://github.com/nikic/FastRoute)

So far these are the most popular ones: **Symfony Routing** component is used not only by
them but by **Laravel** as well, and **FastRoute** is used by other popular solutions such
as the [Slim](https://github.com/slimphp/Slim) framework and [League\Route](https://github.com/thephpleague/route).

# Benchmarks

This is the list of the available [phpbench](https://github.com/phpbench/phpbench)
benchmarks. They are combination of the packages and the strategies they provide.

* [symfony/routing](https://github.com/symfony/routing)
	* [benchmark/Symfony.php](benchmark/Symfony.php) with `Symfony\Component\Routing\Matcher\UrlMatcher`
	* [benchmark/Symfony_Compiled.php](benchmark/Symfony_Compiled.php) with `Symfony\Component\Routing\Matcher\CompiledUrlMatcher`

* [nikic/FastRoute](https://github.com/nikic/FastRoute) with `simpleDispatcher()`
	* [benchmark/FastRoute_GroupCountBased.php](benchmark/FastRoute_GroupCountBased.php) with `FastRoute\Dispatcher\GroupCountBased`
	* [benchmark/FastRoute_GroupPosBased.php](benchmark/FastRoute_GroupPosBased.php) with `FastRoute\Dispatcher\GroupPosBased`
	* [benchmark/FastRoute_CharCountBased.php](benchmark/FastRoute_CharCountBased.php) with `FastRoute\Dispatcher\CharCountBased`
	* [benchmark/FastRoute_MarkBased.php](benchmark/FastRoute_MarkBased.php) with `FastRoute\Dispatcher\MarkBased`

* [nikic/FastRoute](https://github.com/nikic/FastRoute) with `cachedDispatcher()`
	* [benchmark/FastRoute_Cached_GroupCountBased.php](benchmark/FastRoute_Cached_GroupCountBased.php) with `FastRoute\Dispatcher\GroupCountBased`
	* [benchmark/FastRoute_Cached_GroupPosBased.php](benchmark/FastRoute_Cached_GroupPosBased.php) with `FastRoute\Dispatcher\GroupPosBased`
	* [benchmark/FastRoute_Cached_CharCountBased.php](benchmark/FastRoute_Cached_CharCountBased.php) with `FastRoute\Dispatcher\CharCountBased`
	* [benchmark/FastRoute_Cached_MarkBased.php](benchmark/FastRoute_Cached_MarkBased.php) with `FastRoute\Dispatcher\MarkBased`

The benchmark cases are:

* **benchLast** -- match the last route in the list of routing definitions, as this is considered the worst case
* **benchLongest** -- match the longest route to test the complexity of parsing bigger paths
* **benchAll** -- match all of the routes from the list of routing definitions to average the overall performance
* **benchSetup** -- track how much time is needed to setup the routes collection before the routing starts

### Running the benchmarks

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

### Quick Benchmark

In addition to the phpbench running its own cases, there is also a script that
will run all of the scenarios against all of the packages and strategies, and
calculate the number of routes matched per second. The results are then sorted
by that data. Here's how to run this:

```sh
php scripts/quick-benchmark.php
```

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

# Results

Here are the results from the benchmarks executed by Github Actions:

https://github.com/kktsvetkov/benchmark-php-routing/actions

## PHP 7.3
```
+-------------------------+--------------+--------+------------------+-----------------+
| Case                    | Scenario     | Routes | Time             | Per Second      |
+-------------------------+--------------+--------+------------------+-----------------+
| fast_cached_mark        | benchSetup   | 364    | 0.084102 seconds | 4328.0698965273 |
| fast_cached_group_count | benchSetup   | 364    | 0.086580 seconds | 4204.2139328417 |
| fast_cached_group_pos   | benchSetup   | 364    | 0.086911 seconds | 4188.1828097396 |
| fast_cached_char_count  | benchSetup   | 364    | 0.088954 seconds | 4092.003902439  |
| symfony_compiled        | benchSetup   | 364    | 0.143180 seconds | 2542.2563959104 |
| fast_cached_mark        | benchLast    | 364    | 0.153635 seconds | 2369.251412184  |
| fast_cached_group_pos   | benchLast    | 364    | 0.156722 seconds | 2322.5864523481 |
| fast_cached_group_count | benchLast    | 364    | 0.158214 seconds | 2300.6834810887 |
| fast_cached_char_count  | benchLast    | 364    | 0.159644 seconds | 2280.0747556359 |
| fast_cached_mark        | benchAll     | 364    | 0.177146 seconds | 2054.8027413042 |
| fast_cached_group_pos   | benchAll     | 364    | 0.183265 seconds | 1986.1951711335 |
| fast_cached_group_count | benchAll     | 364    | 0.184834 seconds | 1969.3346094808 |
| fast_cached_char_count  | benchAll     | 364    | 0.188096 seconds | 1935.1815568389 |
| symfony_compiled        | benchLast    | 364    | 0.210052 seconds | 1732.904122712  |
| symfony_compiled        | benchAll     | 364    | 0.292914 seconds | 1242.6849209366 |
| symfony                 | benchSetup   | 364    | 0.379384 seconds | 959.45055556917 |
| fast_cached_mark        | benchLongest | 364    | 0.430258 seconds | 846.00395537486 |
| fast_cached_group_pos   | benchLongest | 364    | 0.431264 seconds | 844.0307200368  |
| fast_cached_char_count  | benchLongest | 364    | 0.441909 seconds | 823.69885745947 |
| fast_cached_group_count | benchLongest | 364    | 0.449693 seconds | 809.44117140269 |
| symfony_compiled        | benchLongest | 364    | 0.492599 seconds | 738.93774097216 |
| fast_char_count         | benchSetup   | 364    | 0.879585 seconds | 413.83150979048 |
| fast_group_pos          | benchSetup   | 364    | 0.879655 seconds | 413.79864590166 |
| fast_mark               | benchSetup   | 364    | 0.883319 seconds | 412.0820932444  |
| fast_group_count        | benchSetup   | 364    | 0.908889 seconds | 400.4890293052  |
| fast_group_pos          | benchLast    | 364    | 0.954757 seconds | 381.24885124163 |
| fast_mark               | benchLast    | 364    | 0.954898 seconds | 381.19259390202 |
| fast_char_count         | benchLast    | 364    | 0.957600 seconds | 380.11700736842 |
| fast_group_count        | benchLast    | 364    | 0.985705 seconds | 369.27887893273 |
| fast_char_count         | benchLongest | 364    | 1.228951 seconds | 296.18756705185 |
| fast_group_pos          | benchLongest | 364    | 1.239102 seconds | 293.76115385873 |
| fast_mark               | benchLongest | 364    | 1.246619 seconds | 291.98977718931 |
| fast_group_count        | benchLongest | 364    | 1.256083 seconds | 289.78976439499 |
| symfony                 | benchLongest | 364    | 1.554957 seconds | 234.09008761474 |
| fast_mark               | benchAll     | 364    | 1.752358 seconds | 207.7201167577  |
| fast_char_count         | benchAll     | 364    | 1.775573 seconds | 205.00424194402 |
| fast_group_count        | benchAll     | 364    | 1.801659 seconds | 202.03600034194 |
| fast_group_pos          | benchAll     | 364    | 1.810852 seconds | 201.01034750076 |
| symfony                 | benchLast    | 364    | 2.038484 seconds | 178.56408259114 |
| symfony                 | benchAll     | 364    | 2.502813 seconds | 145.43634915508 |
+-------------------------+--------------+--------+------------------+-----------------+
```

## PHP 7.4
```
+-------------------------+--------------+--------+------------------+-----------------+
| Case                    | Scenario     | Routes | Time             | Per Second      |
+-------------------------+--------------+--------+------------------+-----------------+
| fast_cached_mark        | benchSetup   | 364    | 0.082097 seconds | 4433.7766626009 |
| fast_cached_group_count | benchSetup   | 364    | 0.084824 seconds | 4291.2340167183 |
| fast_cached_group_pos   | benchSetup   | 364    | 0.085092 seconds | 4277.7195308516 |
| fast_cached_char_count  | benchSetup   | 364    | 0.086446 seconds | 4210.7188628196 |
| symfony_compiled        | benchSetup   | 364    | 0.146925 seconds | 2477.4549467098 |
| fast_cached_mark        | benchLast    | 364    | 0.150364 seconds | 2420.7934647487 |
| fast_cached_group_count | benchLast    | 364    | 0.154778 seconds | 2351.7553613294 |
| fast_cached_group_pos   | benchLast    | 364    | 0.155055 seconds | 2347.553396028  |
| fast_cached_char_count  | benchLast    | 364    | 0.155643 seconds | 2338.6855306412 |
| fast_cached_mark        | benchAll     | 364    | 0.171287 seconds | 2125.0875603747 |
| fast_cached_group_pos   | benchAll     | 364    | 0.179029 seconds | 2033.1902911432 |
| fast_cached_group_count | benchAll     | 364    | 0.179543 seconds | 2027.369280985  |
| fast_cached_char_count  | benchAll     | 364    | 0.181577 seconds | 2004.6569098859 |
| symfony_compiled        | benchLast    | 364    | 0.214493 seconds | 1697.0247907795 |
| symfony_compiled        | benchAll     | 364    | 0.298275 seconds | 1220.3503728051 |
| symfony                 | benchSetup   | 364    | 0.348353 seconds | 1044.9173539352 |
| fast_cached_mark        | benchLongest | 364    | 0.394723 seconds | 922.16581420015 |
| fast_cached_group_count | benchLongest | 364    | 0.401662 seconds | 906.23488210308 |
| fast_cached_group_pos   | benchLongest | 364    | 0.403570 seconds | 901.9497039043  |
| fast_cached_char_count  | benchLongest | 364    | 0.425752 seconds | 854.95748862932 |
| symfony_compiled        | benchLongest | 364    | 0.474400 seconds | 767.28492123242 |
| fast_mark               | benchSetup   | 364    | 0.790283 seconds | 460.59451646566 |
| fast_char_count         | benchSetup   | 364    | 0.794591 seconds | 458.09733925916 |
| fast_group_pos          | benchSetup   | 364    | 0.800034 seconds | 454.98063706309 |
| fast_group_count        | benchSetup   | 364    | 0.820718 seconds | 443.51419557627 |
| fast_mark               | benchLast    | 364    | 0.860448 seconds | 423.03538200949 |
| fast_group_pos          | benchLast    | 364    | 0.864935 seconds | 420.8409107448  |
| fast_char_count         | benchLast    | 364    | 0.872505 seconds | 417.18961041942 |
| fast_group_count        | benchLast    | 364    | 0.883238 seconds | 412.12002479101 |
| fast_mark               | benchLongest | 364    | 1.110576 seconds | 327.75780308427 |
| fast_group_pos          | benchLongest | 364    | 1.120827 seconds | 324.76021109151 |
| fast_group_count        | benchLongest | 364    | 1.138113 seconds | 319.82763839054 |
| fast_char_count         | benchLongest | 364    | 1.145466 seconds | 317.77464141442 |
| symfony                 | benchLongest | 364    | 1.432371 seconds | 254.12412365993 |
| fast_mark               | benchAll     | 364    | 1.567705 seconds | 232.18655263814 |
| fast_char_count         | benchAll     | 364    | 1.603382 seconds | 227.02012052808 |
| fast_group_pos          | benchAll     | 364    | 1.603655 seconds | 226.98147502526 |
| fast_group_count        | benchAll     | 364    | 1.625705 seconds | 223.90286009021 |
| symfony                 | benchLast    | 364    | 1.863687 seconds | 195.3117623806  |
| symfony                 | benchAll     | 364    | 2.369112 seconds | 153.64406483552 |
+-------------------------+--------------+--------+------------------+-----------------+
```

## PHP 8.0
```
+-------------------------+--------------+--------+------------------+-----------------+
| Case                    | Scenario     | Routes | Time             | Per Second      |
+-------------------------+--------------+--------+------------------+-----------------+
| fast_cached_mark        | benchSetup   | 364    | 0.096659 seconds | 3765.8180490705 |
| fast_cached_group_pos   | benchSetup   | 364    | 0.098272 seconds | 3704.0019991121 |
| fast_cached_group_count | benchSetup   | 364    | 0.103526 seconds | 3516.0291373708 |
| fast_cached_char_count  | benchSetup   | 364    | 0.106311 seconds | 3423.921632653  |
| symfony_compiled        | benchSetup   | 364    | 0.160830 seconds | 2263.2590479861 |
| fast_cached_mark        | benchLast    | 364    | 0.172737 seconds | 2107.2482664193 |
| fast_cached_group_pos   | benchLast    | 364    | 0.178793 seconds | 2035.874417265  |
| fast_cached_group_count | benchLast    | 364    | 0.183087 seconds | 1988.1272525074 |
| fast_cached_char_count  | benchLast    | 364    | 0.187651 seconds | 1939.7695441043 |
| fast_cached_group_pos   | benchAll     | 364    | 0.203419 seconds | 1789.408201106  |
| fast_cached_group_count | benchAll     | 364    | 0.217068 seconds | 1676.8942093407 |
| fast_cached_mark        | benchAll     | 364    | 0.221577 seconds | 1642.7703077706 |
| fast_cached_char_count  | benchAll     | 364    | 0.222918 seconds | 1632.8871833375 |
| symfony_compiled        | benchLast    | 364    | 0.233139 seconds | 1561.3000850841 |
| symfony_compiled        | benchAll     | 364    | 0.334261 seconds | 1088.9688151082 |
| symfony                 | benchSetup   | 364    | 0.373197 seconds | 975.3565965907  |
| fast_cached_mark        | benchLongest | 364    | 0.482086 seconds | 755.05171868077 |
| fast_cached_group_count | benchLongest | 364    | 0.484509 seconds | 751.27604766904 |
| fast_cached_group_pos   | benchLongest | 364    | 0.485210 seconds | 750.19072898968 |
| fast_cached_char_count  | benchLongest | 364    | 0.488664 seconds | 744.88823748966 |
| symfony_compiled        | benchLongest | 364    | 0.551119 seconds | 660.47459551125 |
| fast_char_count         | benchSetup   | 364    | 0.909515 seconds | 400.21334272836 |
| fast_mark               | benchSetup   | 364    | 0.919115 seconds | 396.03311190937 |
| fast_group_count        | benchSetup   | 364    | 0.950844 seconds | 382.81777144119 |
| fast_group_pos          | benchSetup   | 364    | 0.998270 seconds | 364.63079859605 |
| fast_mark               | benchLast    | 364    | 1.003571 seconds | 362.70476912689 |
| fast_group_count        | benchLast    | 364    | 1.006444 seconds | 361.66941050833 |
| fast_group_pos          | benchLast    | 364    | 1.008364 seconds | 360.98077049026 |
| fast_char_count         | benchLast    | 364    | 1.029087 seconds | 353.71156804525 |
| fast_mark               | benchLongest | 364    | 1.286618 seconds | 282.91225648187 |
| fast_group_pos          | benchLongest | 364    | 1.291351 seconds | 281.87532085905 |
| fast_group_count        | benchLongest | 364    | 1.296115 seconds | 280.83929437302 |
| fast_char_count         | benchLongest | 364    | 1.330681 seconds | 273.54417911303 |
| symfony                 | benchLongest | 364    | 1.471591 seconds | 247.35133677883 |
| fast_mark               | benchAll     | 364    | 1.754800 seconds | 207.43103666833 |
| fast_group_pos          | benchAll     | 364    | 1.798255 seconds | 202.41845941387 |
| fast_char_count         | benchAll     | 364    | 1.833238 seconds | 198.55579174675 |
| symfony                 | benchLast    | 364    | 1.879763 seconds | 193.64144399938 |
| fast_group_count        | benchAll     | 364    | 1.892465 seconds | 192.34172254646 |
| symfony                 | benchAll     | 364    | 2.283624 seconds | 159.39577205059 |
+-------------------------+--------------+--------+------------------+-----------------+
```

# More Benchmarks

[Saif Eddin Gmati](https://github.com/azjezz) created a fork in which there are
benchmark cases included, which re-use the created dispatch objects. This is an
interesting approach and one that is used with solutions like Swoole and ReactPHP:

https://github.com/azjezz/benchmark-php-routing
