# Benchmark PHP Routing

Take a real world routing scenario in the form of a real API and benchmark PHP
routing packages against it.

The APIs used for this benchmark:

* [Bitbucket API](https://api.bitbucket.org/swagger.json)

You can read more about this here:

-  http://kaloyan.info/writing/2021/05/31/benchmark-php-routing.html
-  http://kaloyan.info/writing/2021/06/07/more-php-routing-benchmarks.html

# Packages
Here are the packages that are benchmakred:

* Symfony Routing [symfony/routing](https://github.com/symfony/routing)
* FastRoute [nikic/FastRoute](https://github.com/nikic/FastRoute)

So far these are the most popular ones: **Symfony Routing** component is used
not only by Symfony but by **Laravel** as well, and **FastRoute** is used by
other popular solutions such as the [Slim](https://github.com/slimphp/Slim)
framework and [League\Route](https://github.com/thephpleague/route).

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

# Routes: Bitbucket API

All the routes for this benchmark are read from this address:
https://api.bitbucket.org/swagger.json

Only the paths are used, and the HTTP verbs/methods are ignored.

You can see the list of paths in [routes/provider/bitbucket](routes/provider/bitbucket):

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
| fast_cached_mark        | benchSetup   | 356    | 0.081044 seconds | 4392.6778240955 |
| fast_cached_group_pos   | benchSetup   | 356    | 0.083104 seconds | 4283.7821002743 |
| fast_cached_group_count | benchSetup   | 356    | 0.083248 seconds | 4276.3719012052 |
| fast_cached_char_count  | benchSetup   | 356    | 0.085346 seconds | 4171.2566353882 |
| symfony_compiled        | benchSetup   | 356    | 0.137151 seconds | 2595.6791602999 |
| fast_cached_mark        | benchLast    | 356    | 0.147458 seconds | 2414.2455164564 |
| fast_cached_group_pos   | benchLast    | 356    | 0.151576 seconds | 2348.6561259352 |
| fast_cached_group_count | benchLast    | 356    | 0.151726 seconds | 2346.3347250485 |
| fast_cached_char_count  | benchLast    | 356    | 0.154942 seconds | 2297.6334243253 |
| fast_cached_mark        | benchAll     | 356    | 0.179743 seconds | 1980.6077018581 |
| fast_cached_group_count | benchAll     | 356    | 0.186488 seconds | 1908.9684628248 |
| fast_cached_group_pos   | benchAll     | 356    | 0.186718 seconds | 1906.6186691727 |
| fast_cached_char_count  | benchAll     | 356    | 0.189183 seconds | 1881.7758789955 |
| symfony_compiled        | benchLast    | 356    | 0.201914 seconds | 1763.1262467691 |
| symfony_compiled        | benchAll     | 356    | 0.282449 seconds | 1260.4045018178 |
| symfony                 | benchSetup   | 356    | 0.367974 seconds | 967.45954470501 |
| fast_cached_group_count | benchLongest | 356    | 0.407785 seconds | 873.00919214159 |
| fast_cached_group_pos   | benchLongest | 356    | 0.408505 seconds | 871.47044054083 |
| fast_cached_mark        | benchLongest | 356    | 0.414022 seconds | 859.85775343299 |
| fast_cached_char_count  | benchLongest | 356    | 0.421565 seconds | 844.47227079718 |
| symfony_compiled        | benchLongest | 356    | 0.468215 seconds | 760.33448006859 |
| fast_mark               | benchSetup   | 356    | 0.852036 seconds | 417.82272144988 |
| fast_group_pos          | benchSetup   | 356    | 0.853991 seconds | 416.86620445362 |
| fast_group_count        | benchSetup   | 356    | 0.868674 seconds | 409.82000574725 |
| fast_char_count         | benchSetup   | 356    | 0.868996 seconds | 409.66821360539 |
| fast_mark               | benchLast    | 356    | 0.914742 seconds | 389.18077746901 |
| fast_group_pos          | benchLast    | 356    | 0.926495 seconds | 384.24381253535 |
| fast_char_count         | benchLast    | 356    | 0.934291 seconds | 381.03764615817 |
| fast_group_count        | benchLast    | 356    | 0.946371 seconds | 376.17379492151 |
| fast_mark               | benchLongest | 356    | 1.190140 seconds | 299.12447050758 |
| fast_group_pos          | benchLongest | 356    | 1.197570 seconds | 297.26867360599 |
| fast_char_count         | benchLongest | 356    | 1.207677 seconds | 294.78083391441 |
| fast_group_count        | benchLongest | 356    | 1.213106 seconds | 293.46153955005 |
| symfony                 | benchLongest | 356    | 1.516601 seconds | 234.73542473723 |
| fast_mark               | benchAll     | 356    | 1.703022 seconds | 209.04016468169 |
| fast_group_pos          | benchAll     | 356    | 1.712741 seconds | 207.85394383468 |
| fast_char_count         | benchAll     | 356    | 1.728209 seconds | 205.99360155306 |
| fast_group_count        | benchAll     | 356    | 1.769526 seconds | 201.18381930306 |
| symfony                 | benchLast    | 356    | 1.972127 seconds | 180.5157614517  |
| symfony                 | benchAll     | 356    | 2.437803 seconds | 146.03312721207 |
+-------------------------+--------------+--------+------------------+-----------------+
```

## PHP 7.4
```
+-------------------------+--------------+--------+------------------+-----------------+
| Case                    | Scenario     | Routes | Time             | Per Second      |
+-------------------------+--------------+--------+------------------+-----------------+
| fast_cached_mark        | benchSetup   | 356    | 0.078897 seconds | 4512.2121613209 |
| fast_cached_group_count | benchSetup   | 356    | 0.081855 seconds | 4349.1508745358 |
| fast_cached_group_pos   | benchSetup   | 356    | 0.081974 seconds | 4342.8388477826 |
| fast_cached_char_count  | benchSetup   | 356    | 0.085873 seconds | 4145.6508282016 |
| symfony_compiled        | benchSetup   | 356    | 0.140676 seconds | 2530.6373894562 |
| fast_cached_mark        | benchLast    | 356    | 0.144430 seconds | 2464.8591313075 |
| fast_cached_group_pos   | benchLast    | 356    | 0.148458 seconds | 2397.9845506024 |
| fast_cached_group_count | benchLast    | 356    | 0.149128 seconds | 2387.2116235643 |
| fast_cached_char_count  | benchLast    | 356    | 0.149337 seconds | 2383.8691880932 |
| fast_cached_mark        | benchAll     | 356    | 0.174140 seconds | 2044.332422412  |
| fast_cached_group_count | benchAll     | 356    | 0.180319 seconds | 1974.2781414573 |
| fast_cached_group_pos   | benchAll     | 356    | 0.181338 seconds | 1963.1839934156 |
| fast_cached_char_count  | benchAll     | 356    | 0.181801 seconds | 1958.1841792246 |
| symfony_compiled        | benchLast    | 356    | 0.204160 seconds | 1743.7306206054 |
| symfony_compiled        | benchAll     | 356    | 0.285834 seconds | 1245.4778221249 |
| symfony                 | benchSetup   | 356    | 0.327561 seconds | 1086.8207964247 |
| fast_cached_mark        | benchLongest | 356    | 0.384184 seconds | 926.63902419348 |
| fast_cached_group_count | benchLongest | 356    | 0.387971 seconds | 917.59453513497 |
| fast_cached_group_pos   | benchLongest | 356    | 0.390963 seconds | 910.57191956667 |
| fast_cached_char_count  | benchLongest | 356    | 0.410079 seconds | 868.1254049428  |
| symfony_compiled        | benchLongest | 356    | 0.452083 seconds | 787.46582539365 |
| fast_mark               | benchSetup   | 356    | 0.668205 seconds | 532.77061357891 |
| fast_group_pos          | benchSetup   | 356    | 0.672789 seconds | 529.14074831646 |
| fast_char_count         | benchSetup   | 356    | 0.677471 seconds | 525.48380778028 |
| fast_mark               | benchLast    | 356    | 0.723705 seconds | 491.91310515546 |
| fast_char_count         | benchLast    | 356    | 0.736563 seconds | 483.32579911115 |
| fast_group_pos          | benchLast    | 356    | 0.744195 seconds | 478.36925462455 |
| fast_group_count        | benchSetup   | 356    | 0.777405 seconds | 457.93375293996 |
| fast_group_count        | benchLast    | 356    | 0.845138 seconds | 421.23306453319 |
| fast_mark               | benchLongest | 356    | 0.939338 seconds | 378.99032277469 |
| fast_group_pos          | benchLongest | 356    | 0.942222 seconds | 377.83023032081 |
| fast_char_count         | benchLongest | 356    | 0.957846 seconds | 371.66729035516 |
| fast_group_count        | benchLongest | 356    | 0.959980 seconds | 370.8410549447  |
| fast_mark               | benchAll     | 356    | 1.358047 seconds | 262.1411466378  |
| fast_group_pos          | benchAll     | 356    | 1.384728 seconds | 257.09016522293 |
| symfony                 | benchLongest | 356    | 1.387835 seconds | 256.51468261214 |
| fast_group_count        | benchAll     | 356    | 1.406458 seconds | 253.11809148256 |
| fast_char_count         | benchAll     | 356    | 1.534142 seconds | 232.0515284573  |
| symfony                 | benchLast    | 356    | 1.803962 seconds | 197.34340386698 |
| symfony                 | benchAll     | 356    | 2.183313 seconds | 163.054961639   |
+-------------------------+--------------+--------+------------------+-----------------+
```

## PHP 8.0
```
+-------------------------+--------------+--------+------------------+-----------------+
| Case                    | Scenario     | Routes | Time             | Per Second      |
+-------------------------+--------------+--------+------------------+-----------------+
| fast_cached_mark        | benchSetup   | 356    | 0.085140 seconds | 4181.3488657334 |
| fast_cached_group_count | benchSetup   | 356    | 0.087689 seconds | 4059.8058260874 |
| fast_cached_group_pos   | benchSetup   | 356    | 0.088396 seconds | 4027.3391178636 |
| fast_cached_char_count  | benchSetup   | 356    | 0.090483 seconds | 3934.4428886494 |
| symfony_compiled        | benchSetup   | 356    | 0.140821 seconds | 2528.0323984248 |
| fast_cached_mark        | benchLast    | 356    | 0.152601 seconds | 2332.8811180289 |
| fast_cached_group_pos   | benchLast    | 356    | 0.156569 seconds | 2273.7578369357 |
| fast_cached_group_count | benchLast    | 356    | 0.157109 seconds | 2265.9424337937 |
| fast_cached_char_count  | benchLast    | 356    | 0.158945 seconds | 2239.7706547387 |
| fast_cached_mark        | benchAll     | 356    | 0.187400 seconds | 1899.6787890276 |
| fast_cached_group_pos   | benchAll     | 356    | 0.193652 seconds | 1838.3500144662 |
| fast_cached_group_count | benchAll     | 356    | 0.193672 seconds | 1838.1599150088 |
| fast_cached_char_count  | benchAll     | 356    | 0.197808 seconds | 1799.7269069722 |
| symfony_compiled        | benchLast    | 356    | 0.205411 seconds | 1733.1110502393 |
| symfony_compiled        | benchAll     | 356    | 0.286008 seconds | 1244.7199069694 |
| symfony                 | benchSetup   | 356    | 0.336524 seconds | 1057.8739992802 |
| fast_cached_mark        | benchLongest | 356    | 0.399151 seconds | 891.89338175563 |
| fast_cached_char_count  | benchLongest | 356    | 0.404460 seconds | 880.18550967946 |
| fast_cached_group_pos   | benchLongest | 356    | 0.405235 seconds | 878.50248429263 |
| fast_cached_group_count | benchLongest | 356    | 0.408049 seconds | 872.44401284968 |
| symfony_compiled        | benchLongest | 356    | 0.459004 seconds | 775.59249574849 |
| fast_mark               | benchSetup   | 356    | 0.783287 seconds | 454.4949399515  |
| fast_group_pos          | benchSetup   | 356    | 0.787948 seconds | 451.80638894924 |
| fast_char_count         | benchSetup   | 356    | 0.799040 seconds | 445.53459745535 |
| fast_group_count        | benchSetup   | 356    | 0.809225 seconds | 439.92704594041 |
| fast_mark               | benchLast    | 356    | 0.859560 seconds | 414.1653807663  |
| fast_group_pos          | benchLast    | 356    | 0.861331 seconds | 413.31381986357 |
| fast_char_count         | benchLast    | 356    | 0.867691 seconds | 410.28428734723 |
| fast_group_count        | benchLast    | 356    | 0.875441 seconds | 406.65226635511 |
| fast_group_pos          | benchLongest | 356    | 1.106857 seconds | 321.63148169928 |
| fast_mark               | benchLongest | 356    | 1.111476 seconds | 320.29483117069 |
| fast_char_count         | benchLongest | 356    | 1.124085 seconds | 316.702042991   |
| fast_group_count        | benchLongest | 356    | 1.143600 seconds | 311.2976600538  |
| symfony                 | benchLongest | 356    | 1.338053 seconds | 266.05822278995 |
| fast_group_pos          | benchAll     | 356    | 1.588046 seconds | 224.17485603719 |
| fast_char_count         | benchAll     | 356    | 1.592408 seconds | 223.56077067317 |
| fast_mark               | benchAll     | 356    | 1.608985 seconds | 221.2575081069  |
| fast_group_count        | benchAll     | 356    | 1.626155 seconds | 218.92133405507 |
| symfony                 | benchLast    | 356    | 1.675463 seconds | 212.47858546851 |
| symfony                 | benchAll     | 356    | 2.095318 seconds | 169.90262436848 |
+-------------------------+--------------+--------+------------------+-----------------+
```
