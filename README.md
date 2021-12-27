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

## PHP 7.2
```
+-------------------------+--------------+--------+------------------+-----------------+
| Case                    | Scenario     | Routes | Time             | Per Second      |
+-------------------------+--------------+--------+------------------+-----------------+
| fast_cached_group_pos   | benchSetup   | 364    | 0.123430 seconds | 2949.0396153778 |
| fast_cached_group_count | benchSetup   | 364    | 0.124486 seconds | 2924.0243003684 |
| fast_cached_mark        | benchSetup   | 364    | 0.130642 seconds | 2786.2415978042 |
| fast_cached_char_count  | benchSetup   | 364    | 0.137595 seconds | 2645.4461519801 |
| symfony_compiled        | benchSetup   | 364    | 0.220942 seconds | 1647.4910445474 |
| fast_cached_group_pos   | benchLast    | 364    | 0.223166 seconds | 1631.0729146413 |
| fast_cached_group_count | benchLast    | 364    | 0.223993 seconds | 1625.0520556811 |
| fast_cached_char_count  | benchLast    | 364    | 0.236138 seconds | 1541.4708244357 |
| fast_cached_mark        | benchLast    | 364    | 0.246764 seconds | 1475.0925175169 |
| fast_cached_group_pos   | benchAll     | 364    | 0.260565 seconds | 1396.964061309  |
| fast_cached_mark        | benchAll     | 364    | 0.263463 seconds | 1381.5980684932 |
| fast_cached_group_count | benchAll     | 364    | 0.271484 seconds | 1340.779333372  |
| fast_cached_char_count  | benchAll     | 364    | 0.271501 seconds | 1340.6945602138 |
| symfony_compiled        | benchLast    | 364    | 0.300495 seconds | 1211.3340357737 |
| symfony_compiled        | benchAll     | 364    | 0.416559 seconds | 873.82583656475 |
| symfony                 | benchSetup   | 364    | 0.499148 seconds | 729.24278722837 |
| fast_cached_group_pos   | benchLongest | 364    | 0.554966 seconds | 655.89606890247 |
| fast_cached_group_count | benchLongest | 364    | 0.565564 seconds | 643.60541568461 |
| fast_cached_char_count  | benchLongest | 364    | 0.575502 seconds | 632.49137511756 |
| fast_cached_mark        | benchLongest | 364    | 0.585382 seconds | 621.81619781124 |
| symfony_compiled        | benchLongest | 364    | 0.638351 seconds | 570.21923794314 |
| fast_group_pos          | benchSetup   | 364    | 1.120921 seconds | 324.73292602932 |
| fast_char_count         | benchSetup   | 364    | 1.122213 seconds | 324.35906497329 |
| fast_mark               | benchSetup   | 364    | 1.211071 seconds | 300.56040948106 |
| fast_char_count         | benchLast    | 364    | 1.229123 seconds | 296.1460860983  |
| fast_group_pos          | benchLast    | 364    | 1.235431 seconds | 294.63402893181 |
| fast_group_count        | benchSetup   | 364    | 1.245390 seconds | 292.27793544    |
| fast_mark               | benchLast    | 364    | 1.286308 seconds | 282.9804259998  |
| fast_group_count        | benchLast    | 364    | 1.309469 seconds | 277.97527416055 |
| fast_group_count        | benchLongest | 364    | 1.584126 seconds | 229.77970250015 |
| fast_mark               | benchLongest | 364    | 1.609245 seconds | 226.19301971076 |
| fast_char_count         | benchLongest | 364    | 1.617329 seconds | 225.06241639726 |
| fast_group_pos          | benchLongest | 364    | 1.632724 seconds | 222.94030686575 |
| symfony                 | benchLongest | 364    | 1.949010 seconds | 186.7614712197  |
| fast_char_count         | benchAll     | 364    | 2.299838 seconds | 158.27201287136 |
| fast_group_count        | benchAll     | 364    | 2.314364 seconds | 157.27863328727 |
| fast_group_pos          | benchAll     | 364    | 2.353333 seconds | 154.67424311039 |
| fast_mark               | benchAll     | 364    | 2.366691 seconds | 153.80122825267 |
| symfony                 | benchLast    | 364    | 2.576549 seconds | 141.2742363857  |
| symfony                 | benchAll     | 364    | 3.203881 seconds | 113.61220879427 |
+-------------------------+--------------+--------+------------------+-----------------+
```

## PHP 7.3
```
+-------------------------+--------------+--------+------------------+-----------------+
| Case                    | Scenario     | Routes | Time             | Per Second      |
+-------------------------+--------------+--------+------------------+-----------------+
| fast_cached_group_pos   | benchSetup   | 364    | 0.123430 seconds | 2949.0396153778 |
| fast_cached_group_count | benchSetup   | 364    | 0.124486 seconds | 2924.0243003684 |
| fast_cached_mark        | benchSetup   | 364    | 0.130642 seconds | 2786.2415978042 |
| fast_cached_char_count  | benchSetup   | 364    | 0.137595 seconds | 2645.4461519801 |
| symfony_compiled        | benchSetup   | 364    | 0.220942 seconds | 1647.4910445474 |
| fast_cached_group_pos   | benchLast    | 364    | 0.223166 seconds | 1631.0729146413 |
| fast_cached_group_count | benchLast    | 364    | 0.223993 seconds | 1625.0520556811 |
| fast_cached_char_count  | benchLast    | 364    | 0.236138 seconds | 1541.4708244357 |
| fast_cached_mark        | benchLast    | 364    | 0.246764 seconds | 1475.0925175169 |
| fast_cached_group_pos   | benchAll     | 364    | 0.260565 seconds | 1396.964061309  |
| fast_cached_mark        | benchAll     | 364    | 0.263463 seconds | 1381.5980684932 |
| fast_cached_group_count | benchAll     | 364    | 0.271484 seconds | 1340.779333372  |
| fast_cached_char_count  | benchAll     | 364    | 0.271501 seconds | 1340.6945602138 |
| symfony_compiled        | benchLast    | 364    | 0.300495 seconds | 1211.3340357737 |
| symfony_compiled        | benchAll     | 364    | 0.416559 seconds | 873.82583656475 |
| symfony                 | benchSetup   | 364    | 0.499148 seconds | 729.24278722837 |
| fast_cached_group_pos   | benchLongest | 364    | 0.554966 seconds | 655.89606890247 |
| fast_cached_group_count | benchLongest | 364    | 0.565564 seconds | 643.60541568461 |
| fast_cached_char_count  | benchLongest | 364    | 0.575502 seconds | 632.49137511756 |
| fast_cached_mark        | benchLongest | 364    | 0.585382 seconds | 621.81619781124 |
| symfony_compiled        | benchLongest | 364    | 0.638351 seconds | 570.21923794314 |
| fast_group_pos          | benchSetup   | 364    | 1.120921 seconds | 324.73292602932 |
| fast_char_count         | benchSetup   | 364    | 1.122213 seconds | 324.35906497329 |
| fast_mark               | benchSetup   | 364    | 1.211071 seconds | 300.56040948106 |
| fast_char_count         | benchLast    | 364    | 1.229123 seconds | 296.1460860983  |
| fast_group_pos          | benchLast    | 364    | 1.235431 seconds | 294.63402893181 |
| fast_group_count        | benchSetup   | 364    | 1.245390 seconds | 292.27793544    |
| fast_mark               | benchLast    | 364    | 1.286308 seconds | 282.9804259998  |
| fast_group_count        | benchLast    | 364    | 1.309469 seconds | 277.97527416055 |
| fast_group_count        | benchLongest | 364    | 1.584126 seconds | 229.77970250015 |
| fast_mark               | benchLongest | 364    | 1.609245 seconds | 226.19301971076 |
| fast_char_count         | benchLongest | 364    | 1.617329 seconds | 225.06241639726 |
| fast_group_pos          | benchLongest | 364    | 1.632724 seconds | 222.94030686575 |
| symfony                 | benchLongest | 364    | 1.949010 seconds | 186.7614712197  |
| fast_char_count         | benchAll     | 364    | 2.299838 seconds | 158.27201287136 |
| fast_group_count        | benchAll     | 364    | 2.314364 seconds | 157.27863328727 |
| fast_group_pos          | benchAll     | 364    | 2.353333 seconds | 154.67424311039 |
| fast_mark               | benchAll     | 364    | 2.366691 seconds | 153.80122825267 |
| symfony                 | benchLast    | 364    | 2.576549 seconds | 141.2742363857  |
| symfony                 | benchAll     | 364    | 3.203881 seconds | 113.61220879427 |
+-------------------------+--------------+--------+------------------+-----------------+
```

## PHP 7.4
```
+-------------------------+--------------+--------+------------------+-----------------+
| Case                    | Scenario     | Routes | Time             | Per Second      |
+-------------------------+--------------+--------+------------------+-----------------+
| fast_cached_mark        | benchSetup   | 364    | 0.097683 seconds | 3726.3410786113 |
| fast_cached_group_pos   | benchSetup   | 364    | 0.098034 seconds | 3713.0011284486 |
| fast_cached_group_count | benchSetup   | 364    | 0.099076 seconds | 3673.9460624947 |
| fast_cached_char_count  | benchSetup   | 364    | 0.101263 seconds | 3594.5985571942 |
| symfony_compiled        | benchSetup   | 364    | 0.172306 seconds | 2112.5229257385 |
| fast_cached_group_pos   | benchLast    | 364    | 0.176123 seconds | 2066.7385791235 |
| fast_cached_group_count | benchLast    | 364    | 0.179723 seconds | 2025.3387192844 |
| fast_cached_char_count  | benchLast    | 364    | 0.181172 seconds | 2009.1390159904 |
| fast_cached_mark        | benchLast    | 364    | 0.188490 seconds | 1931.1353693784 |
| fast_cached_group_pos   | benchAll     | 364    | 0.208146 seconds | 1748.7716957532 |
| fast_cached_mark        | benchAll     | 364    | 0.208594 seconds | 1745.015934265  |
| fast_cached_group_count | benchAll     | 364    | 0.209834 seconds | 1734.7037590841 |
| fast_cached_char_count  | benchAll     | 364    | 0.212305 seconds | 1714.5139386752 |
| symfony_compiled        | benchLast    | 364    | 0.254555 seconds | 1429.9464502974 |
| symfony_compiled        | benchAll     | 364    | 0.346181 seconds | 1051.4733289807 |
| symfony                 | benchSetup   | 364    | 0.417051 seconds | 872.7947730413  |
| fast_cached_group_count | benchLongest | 364    | 0.490493 seconds | 742.11039932881 |
| fast_cached_group_pos   | benchLongest | 364    | 0.496156 seconds | 733.64025969844 |
| fast_cached_char_count  | benchLongest | 364    | 0.516545 seconds | 704.68199212849 |
| fast_cached_mark        | benchLongest | 364    | 0.526740 seconds | 691.04292203713 |
| symfony_compiled        | benchLongest | 364    | 0.572678 seconds | 635.61040389511 |
| fast_mark               | benchSetup   | 364    | 0.961564 seconds | 378.55001436863 |
| fast_group_pos          | benchSetup   | 364    | 0.980140 seconds | 371.37552885487 |
| fast_char_count         | benchSetup   | 364    | 0.980272 seconds | 371.3254889447  |
| fast_group_count        | benchSetup   | 364    | 1.033555 seconds | 352.18250518332 |
| fast_char_count         | benchLast    | 364    | 1.048563 seconds | 347.14175378219 |
| fast_group_pos          | benchLast    | 364    | 1.062764 seconds | 342.50307926587 |
| fast_mark               | benchLast    | 364    | 1.069771 seconds | 340.25979731416 |
| fast_group_count        | benchLast    | 364    | 1.087661 seconds | 334.6630895657  |
| fast_mark               | benchLongest | 364    | 1.364222 seconds | 266.81878048451 |
| fast_group_pos          | benchLongest | 364    | 1.370633 seconds | 265.57070107214 |
| fast_char_count         | benchLongest | 364    | 1.395774 seconds | 260.78718125357 |
| fast_group_count        | benchLongest | 364    | 1.403335 seconds | 259.38214135783 |
| symfony                 | benchLongest | 364    | 1.725807 seconds | 210.91582675502 |
| fast_mark               | benchAll     | 364    | 1.944290 seconds | 187.21485469428 |
| fast_group_pos          | benchAll     | 364    | 1.959225 seconds | 185.78775345798 |
| fast_char_count         | benchAll     | 364    | 1.983565 seconds | 183.50796828001 |
| fast_group_count        | benchAll     | 364    | 2.020916 seconds | 180.11634460928 |
| symfony                 | benchLast    | 364    | 2.250827 seconds | 161.71834911402 |
| symfony                 | benchAll     | 364    | 2.810412 seconds | 129.51837988714 |
+-------------------------+--------------+--------+------------------+-----------------+
```

# More Benchmarks

[Saif Eddin Gmati](https://github.com/azjezz) created a fork in which there are
benchmark cases included, which re-use the created dispatch objects. This is an
interesting approach and one that is used with solutions like Swoole and ReactPHP:

https://github.com/azjezz/benchmark-php-routing
