# Benchmark PHP Routing

Take a real world routing scenario in the form of [Bitbucket API](https://developer.atlassian.com/bitbucket/api/2/reference/resource/) and benchmark PHP routing packages against it.

You can read more about this here: http://kaloyan.info/writing/2021/05/31/benchmark-php-routing.html

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

| File | Strategy |
|------|----------|
| [benchmark/Symfony.php](benchmark/Symfony.php) | `Symfony\Component\Routing\Matcher\UrlMatcher` |
| [benchmark/Symfony_Compiled.php](benchmark/Symfony_Compiled.php) | `Symfony\Component\Routing\Matcher\CompiledUrlMatcher` |

 * [nikic/FastRoute](https://github.com/nikic/FastRoute) with `simpleDispatcher()`

| File | Strategy |
|------|----------|
| [benchmark/FastRoute_GroupCountBased.php](benchmark/FastRoute_GroupCountBased.php) | `FastRoute\Dispatcher\GroupCountBased` |
| [benchmark/FastRoute_GroupPosBased.php](benchmark/FastRoute_GroupPosBased.php) | `FastRoute\Dispatcher\GroupPosBased` |
| [benchmark/FastRoute_CharCountBased.php](benchmark/FastRoute_CharCountBased.php) | `FastRoute\Dispatcher\CharCountBased` |
| [benchmark/FastRoute_MarkBased.php](benchmark/FastRoute_MarkBased.php) | `FastRoute\Dispatcher\MarkBased` |

* [nikic/FastRoute](https://github.com/nikic/FastRoute) with `cachedDispatcher()`

| File | Strategy |
|------|----------|
| [benchmark/FastRoute_Cached_GroupCountBased.php](benchmark/FastRoute_Cached_GroupCountBased.php) | `FastRoute\Dispatcher\GroupCountBased` |
| [benchmark/FastRoute_Cached_GroupPosBased.php](benchmark/FastRoute_Cached_GroupPosBased.php) | `FastRoute\Dispatcher\GroupPosBased` |
| [benchmark/FastRoute_Cached_CharCountBased.php](benchmark/FastRoute_Cached_CharCountBased.php) | `FastRoute\Dispatcher\CharCountBased` |
| [benchmark/FastRoute_Cached_MarkBased.php](benchmark/FastRoute_Cached_MarkBased.php) | `FastRoute\Dispatcher\MarkBased` |

The benchmark cases are:

* **benchLast** -- match the last route in the list of routing definitions, as this is considered the worst case
* **benchLongest** -- match the longest route to test the complexity of parsing bigger paths
* **benchAll** -- match all of the routes from the list of routing definitions to average the overall performance

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

## PHP 7.1
```
+-------------------------+--------------+--------+------------------+-----------------+
| Case                    | Scenario     | Routes | Time             | Per Second      |
+-------------------------+--------------+--------+------------------+-----------------+
| fast_cached_mark        | benchAll     | 364    | 0.245389 seconds | 1483.3591673824 |
| fast_cached_char_count  | benchAll     | 364    | 0.249807 seconds | 1457.125594837  |
| fast_cached_group_pos   | benchAll     | 364    | 0.254083 seconds | 1432.6031935787 |
| fast_cached_group_count | benchAll     | 364    | 0.260062 seconds | 1399.665061699  |
| symfony_compiled        | benchAll     | 364    | 0.413057 seconds | 881.23411950566 |
| fast_cached_mark        | benchLast    | 300    | 0.340637 seconds | 880.70299950656 |
| fast_cached_group_count | benchLast    | 300    | 0.342824 seconds | 875.08463684742 |
| fast_cached_char_count  | benchLast    | 300    | 0.351849 seconds | 852.63887580713 |
| fast_cached_group_pos   | benchLast    | 300    | 0.365263 seconds | 821.32603666784 |
| symfony_compiled        | benchLast    | 300    | 0.493613 seconds | 607.76356609928 |
| fast_cached_mark        | benchLongest | 300    | 1.061979 seconds | 282.49144695766 |
| fast_cached_group_pos   | benchLongest | 300    | 1.076209 seconds | 278.75624619514 |
| fast_cached_group_count | benchLongest | 300    | 1.087883 seconds | 275.76495010203 |
| fast_cached_char_count  | benchLongest | 300    | 1.112363 seconds | 269.69610910862 |
| symfony_compiled        | benchLongest | 300    | 1.215672 seconds | 246.77708791194 |
| fast_char_count         | benchAll     | 364    | 2.768154 seconds | 131.49556745285 |
| fast_group_pos          | benchAll     | 364    | 2.787809 seconds | 130.56849077365 |
| fast_mark               | benchAll     | 364    | 2.854463 seconds | 127.51960252867 |
| fast_group_count        | benchAll     | 364    | 2.888068 seconds | 126.03581527453 |
| fast_mark               | benchLast    | 300    | 2.428645 seconds | 123.52566284945 |
| fast_char_count         | benchLast    | 300    | 2.504715 seconds | 119.77409626942 |
| fast_group_count        | benchLast    | 300    | 2.540682 seconds | 118.07853915284 |
| fast_group_pos          | benchLast    | 300    | 2.569429 seconds | 116.75746216514 |
| symfony                 | benchAll     | 364    | 3.659201 seconds | 99.475270496406 |
| fast_char_count         | benchLongest | 300    | 3.158607 seconds | 94.978577399213 |
| fast_group_count        | benchLongest | 300    | 3.186798 seconds | 94.138376825474 |
| fast_mark               | benchLongest | 300    | 3.187436 seconds | 94.119533765834 |
| fast_group_pos          | benchLongest | 300    | 3.340925 seconds | 89.795491354189 |
| symfony                 | benchLongest | 300    | 3.612994 seconds | 83.033629085927 |
| symfony                 | benchLast    | 300    | 4.843723 seconds | 61.935831411289 |
+-------------------------+--------------+--------+------------------+-----------------+
```

## PHP 7.2
```
+-------------------------+--------------+--------+------------------+-----------------+
| Case                    | Scenario     | Routes | Time             | Per Second      |
+-------------------------+--------------+--------+------------------+-----------------+
| fast_cached_mark        | benchAll     | 364    | 0.213650 seconds | 1703.7211333838 |
| fast_cached_group_count | benchAll     | 364    | 0.230613 seconds | 1578.4019576929 |
| fast_cached_group_pos   | benchAll     | 364    | 0.231448 seconds | 1572.7079173805 |
| fast_cached_char_count  | benchAll     | 364    | 0.233461 seconds | 1559.1475705827 |
| fast_cached_mark        | benchLast    | 300    | 0.306500 seconds | 978.7921948108  |
| symfony_compiled        | benchAll     | 364    | 0.373521 seconds | 974.50990099327 |
| fast_cached_char_count  | benchLast    | 300    | 0.319633 seconds | 938.57640914251 |
| fast_cached_group_count | benchLast    | 300    | 0.319820 seconds | 938.02785402355 |
| fast_cached_group_pos   | benchLast    | 300    | 0.325751 seconds | 920.94930974062 |
| symfony_compiled        | benchLast    | 300    | 0.452147 seconds | 663.50101927714 |
| fast_cached_group_pos   | benchLongest | 300    | 0.826421 seconds | 363.01109466367 |
| fast_cached_char_count  | benchLongest | 300    | 0.839799 seconds | 357.22836770222 |
| fast_cached_mark        | benchLongest | 300    | 0.843073 seconds | 355.84111779518 |
| fast_cached_group_count | benchLongest | 300    | 0.852549 seconds | 351.88590125425 |
| symfony_compiled        | benchLongest | 300    | 0.957260 seconds | 313.39451497233 |
| fast_mark               | benchAll     | 364    | 2.072627 seconds | 175.62252548766 |
| fast_char_count         | benchAll     | 364    | 2.103555 seconds | 173.04040361108 |
| fast_group_pos          | benchAll     | 364    | 2.121528 seconds | 171.57443809145 |
| fast_group_count        | benchAll     | 364    | 2.126081 seconds | 171.20702444539 |
| fast_mark               | benchLast    | 300    | 1.848153 seconds | 162.32421311617 |
| fast_char_count         | benchLast    | 300    | 1.856099 seconds | 161.62931919579 |
| fast_group_pos          | benchLast    | 300    | 1.876896 seconds | 159.83837956819 |
| fast_group_count        | benchLast    | 300    | 1.970900 seconds | 152.21473811394 |
| symfony                 | benchAll     | 364    | 2.571703 seconds | 141.54045240237 |
| fast_mark               | benchLongest | 300    | 2.346373 seconds | 127.85690494098 |
| fast_char_count         | benchLongest | 300    | 2.369537 seconds | 126.60700610622 |
| fast_group_pos          | benchLongest | 300    | 2.376117 seconds | 126.2564095669  |
| fast_group_count        | benchLongest | 300    | 2.457300 seconds | 122.08520623162 |
| symfony                 | benchLongest | 300    | 2.673281 seconds | 112.22165014515 |
| symfony                 | benchLast    | 300    | 3.383559 seconds | 88.664037190817 |
+-------------------------+--------------+--------+------------------+-----------------+
```

## PHP 7.3
```
+-------------------------+--------------+--------+------------------+-----------------+
| Case                    | Scenario     | Routes | Time             | Per Second      |
+-------------------------+--------------+--------+------------------+-----------------+
| fast_cached_mark        | benchAll     | 364    | 0.212982 seconds | 1709.0651027469 |
| fast_cached_group_count | benchAll     | 364    | 0.218750 seconds | 1664            |
| fast_cached_group_pos   | benchAll     | 364    | 0.221451 seconds | 1643.7041491851 |
| fast_cached_char_count  | benchAll     | 364    | 0.226611 seconds | 1606.2775517504 |
| symfony_compiled        | benchAll     | 364    | 0.345792 seconds | 1052.6564898549 |
| fast_cached_mark        | benchLast    | 300    | 0.290941 seconds | 1031.1368972257 |
| fast_cached_group_pos   | benchLast    | 300    | 0.298009 seconds | 1006.6812807015 |
| fast_cached_group_count | benchLast    | 300    | 0.300559 seconds | 998.139986483   |
| fast_cached_char_count  | benchLast    | 300    | 0.322342 seconds | 930.68806901771 |
| symfony_compiled        | benchLast    | 300    | 0.439923 seconds | 681.93744644805 |
| fast_cached_group_count | benchLongest | 300    | 0.854665 seconds | 351.01480616081 |
| fast_cached_mark        | benchLongest | 300    | 0.872547 seconds | 343.8209615578  |
| fast_cached_char_count  | benchLongest | 300    | 0.878194 seconds | 341.61022443322 |
| fast_cached_group_pos   | benchLongest | 300    | 0.900564 seconds | 333.1245917984  |
| symfony_compiled        | benchLongest | 300    | 1.016180 seconds | 295.22327604169 |
| fast_char_count         | benchAll     | 364    | 2.216095 seconds | 164.2528884421  |
| fast_group_pos          | benchAll     | 364    | 2.221537 seconds | 163.85053254518 |
| fast_mark               | benchAll     | 364    | 2.247656 seconds | 161.94648232648 |
| fast_group_count        | benchAll     | 364    | 2.302350 seconds | 158.09933025128 |
| fast_mark               | benchLast    | 300    | 1.959023 seconds | 153.13755896805 |
| fast_group_pos          | benchLast    | 300    | 1.980528 seconds | 151.47474935707 |
| fast_char_count         | benchLast    | 300    | 2.041746 seconds | 146.93305607013 |
| fast_group_count        | benchLast    | 300    | 2.094186 seconds | 143.25376278568 |
| symfony                 | benchAll     | 364    | 2.811152 seconds | 129.48428345902 |
| fast_mark               | benchLongest | 300    | 2.530609 seconds | 118.5485441453  |
| fast_group_count        | benchLongest | 300    | 2.543774 seconds | 117.93499929986 |
| fast_char_count         | benchLongest | 300    | 2.576504 seconds | 116.436846565   |
| fast_group_pos          | benchLongest | 300    | 2.733477 seconds | 109.75032433397 |
| symfony                 | benchLongest | 300    | 3.127849 seconds | 95.912555310366 |
| symfony                 | benchLast    | 300    | 3.844360 seconds | 78.036398718119 |
+-------------------------+--------------+--------+------------------+-----------------+
```

## PHP 7.4
```
+-------------------------+--------------+--------+------------------+-----------------+
| Case                    | Scenario     | Routes | Time             | Per Second      |
+-------------------------+--------------+--------+------------------+-----------------+
| fast_cached_mark        | benchAll     | 364    | 0.184830 seconds | 1969.3752544393 |
| fast_cached_char_count  | benchAll     | 364    | 0.190946 seconds | 1906.2994762045 |
| fast_cached_group_pos   | benchAll     | 364    | 0.198573 seconds | 1833.0779803957 |
| fast_cached_group_count | benchAll     | 364    | 0.200405 seconds | 1816.3230136136 |
| fast_cached_char_count  | benchLast    | 300    | 0.265815 seconds | 1128.6043973096 |
| symfony_compiled        | benchAll     | 364    | 0.323630 seconds | 1124.7408882992 |
| fast_cached_mark        | benchLast    | 300    | 0.267429 seconds | 1121.7935985194 |
| fast_cached_group_count | benchLast    | 300    | 0.272139 seconds | 1102.3775356263 |
| fast_cached_group_pos   | benchLast    | 300    | 0.274821 seconds | 1091.6204122212 |
| symfony_compiled        | benchLast    | 300    | 0.367107 seconds | 817.20009430048 |
| fast_cached_mark        | benchLongest | 300    | 0.723163 seconds | 414.84415953495 |
| fast_cached_char_count  | benchLongest | 300    | 0.729227 seconds | 411.39449421304 |
| fast_cached_group_pos   | benchLongest | 300    | 0.739985 seconds | 405.41362918457 |
| fast_cached_group_count | benchLongest | 300    | 0.775798 seconds | 386.69855832926 |
| symfony_compiled        | benchLongest | 300    | 0.854253 seconds | 351.18399485124 |
| fast_mark               | benchAll     | 364    | 1.739359 seconds | 209.27250815583 |
| fast_group_count        | benchAll     | 364    | 1.753623 seconds | 207.57026920172 |
| fast_group_pos          | benchAll     | 364    | 1.808081 seconds | 201.31842422393 |
| fast_mark               | benchLast    | 300    | 1.535626 seconds | 195.36004613032 |
| fast_char_count         | benchAll     | 364    | 1.875456 seconds | 194.08612178155 |
| fast_char_count         | benchLast    | 300    | 1.546621 seconds | 193.97123384788 |
| fast_group_pos          | benchLast    | 300    | 1.564864 seconds | 191.70993107962 |
| fast_group_count        | benchLast    | 300    | 1.571994 seconds | 190.84041501369 |
| symfony                 | benchAll     | 364    | 2.233018 seconds | 163.00807872597 |
| fast_mark               | benchLongest | 300    | 2.023856 seconds | 148.2318955379  |
| fast_group_pos          | benchLongest | 300    | 2.036537 seconds | 147.30889250637 |
| fast_group_count        | benchLongest | 300    | 2.042478 seconds | 146.88040095373 |
| fast_char_count         | benchLongest | 300    | 2.085564 seconds | 143.84598826018 |
| symfony                 | benchLongest | 300    | 2.308640 seconds | 129.9466350681  |
| symfony                 | benchLast    | 300    | 2.949923 seconds | 101.6975684065  |
+-------------------------+--------------+--------+------------------+-----------------+
```

# More Benchmarks

[Saif Eddin Gmati](https://github.com/azjezz) created a fork in which there are
benchmark cases included, which re-use the created dispatch objects. This is an
interesting approach and one that is used with solutions like Swoole and ReactPHP:

https://github.com/azjezz/benchmark-php-routing
