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
php vendor/bin/phpbench run benchmark/Symfony/CompiledUrlMatcher_Benchmark.php --report=short
```
Or you can run all of the benchmarks at once
```sh
php vendor/bin/phpbench run --report=short
```

### Quick Benchmark

In addition to the phpbench running its own cases, there is also a script that
will run all of the scenarios against all of the packages and strategies, and
calculate the number of routes matched per second. The results are then sorted
by that data. Here's how to run this:

```sh
php quick.php
```

# Route Providers

The routes used for the benchmarks are provided from real life APIs. There are
several classes that help with reading, downloading and passing the routes.

Only the paths are used, and the HTTP verbs/methods are ignored.

## Route Provider: Bitbucket API

The routes for this benchmark provider are read from this address:
https://api.bitbucket.org/swagger.json

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

# Results

Here are the results from the benchmarks executed by Github Actions:

https://github.com/kktsvetkov/benchmark-php-routing/actions

## PHP 7.3
```
+--------------------------------------------+--------------+-----------+---------+------------------+-------------+
| Class                                      | Case         | Provider  | Repeats | Time             | Per Second  |
+--------------------------------------------+--------------+-----------+---------+------------------+-------------+
| FastRoute\MarkBased_Cached_Benchmark       | benchSetup   | bitbucket | 178     | 0.078344 seconds | 2272.034863 |
| FastRoute\CharCountBased_Cached_Benchmark  | benchSetup   | bitbucket | 178     | 0.079593 seconds | 2236.379167 |
| FastRoute\GroupCountBased_Cached_Benchmark | benchSetup   | bitbucket | 178     | 0.081616 seconds | 2180.940550 |
| FastRoute\CharCountBased_Cached_Benchmark  | benchAll     | bitbucket | 178     | 0.084616 seconds | 2103.622412 |
| FastRoute\GroupCountBased_Cached_Benchmark | benchLongest | bitbucket | 178     | 0.084656 seconds | 2102.627099 |
| FastRoute\GroupPosBased_Cached_Benchmark   | benchSetup   | bitbucket | 178     | 0.085309 seconds | 2086.537619 |
| FastRoute\GroupPosBased_Cached_Benchmark   | benchAll     | bitbucket | 178     | 0.086050 seconds | 2068.569712 |
| FastRoute\MarkBased_Cached_Benchmark       | benchLast    | bitbucket | 178     | 0.086354 seconds | 2061.282215 |
| FastRoute\MarkBased_Cached_Benchmark       | benchAll     | bitbucket | 178     | 0.086965 seconds | 2046.798458 |
| FastRoute\GroupCountBased_Cached_Benchmark | benchLast    | bitbucket | 178     | 0.087645 seconds | 2030.918941 |
| FastRoute\GroupCountBased_Cached_Benchmark | benchAll     | bitbucket | 178     | 0.089645 seconds | 1985.611923 |
| FastRoute\CharCountBased_Cached_Benchmark  | benchLongest | bitbucket | 178     | 0.089892 seconds | 1980.150681 |
| FastRoute\MarkBased_Cached_Benchmark       | benchLongest | bitbucket | 178     | 0.089895 seconds | 1980.087660 |
| FastRoute\CharCountBased_Cached_Benchmark  | benchLast    | bitbucket | 178     | 0.090841 seconds | 1959.466457 |
| FastRoute\GroupPosBased_Cached_Benchmark   | benchLongest | bitbucket | 178     | 0.092148 seconds | 1931.673757 |
| FastRoute\GroupPosBased_Cached_Benchmark   | benchLast    | bitbucket | 178     | 0.095799 seconds | 1858.057569 |
| Symfony\CompiledUrlMatcher_Benchmark       | benchLongest | bitbucket | 178     | 0.155997 seconds | 1141.049051 |
| Symfony\CompiledUrlMatcher_Benchmark       | benchSetup   | bitbucket | 178     | 0.156661 seconds | 1136.211066 |
| Symfony\CompiledUrlMatcher_Benchmark       | benchLast    | bitbucket | 178     | 0.160118 seconds | 1111.679421 |
| Symfony\CompiledUrlMatcher_Benchmark       | benchAll     | bitbucket | 178     | 0.171021 seconds | 1040.807947 |
| Symfony\UrlMatcher_Benchmark               | benchSetup   | bitbucket | 178     | 0.409891 seconds | 434.261908  |
| Symfony\UrlMatcher_Benchmark               | benchAll     | bitbucket | 178     | 0.438629 seconds | 405.809782  |
| FastRoute\CharCountBased_Benchmark         | benchAll     | bitbucket | 178     | 0.981267 seconds | 181.398136  |
| FastRoute\CharCountBased_Benchmark         | benchLongest | bitbucket | 178     | 0.986302 seconds | 180.472082  |
| FastRoute\GroupCountBased_Benchmark        | benchAll     | bitbucket | 178     | 0.988095 seconds | 180.144614  |
| FastRoute\MarkBased_Benchmark              | benchLast    | bitbucket | 178     | 1.004363 seconds | 177.226791  |
| FastRoute\GroupCountBased_Benchmark        | benchSetup   | bitbucket | 178     | 1.005348 seconds | 177.053084  |
| FastRoute\CharCountBased_Benchmark         | benchSetup   | bitbucket | 178     | 1.005444 seconds | 177.036248  |
| FastRoute\MarkBased_Benchmark              | benchLongest | bitbucket | 178     | 1.013495 seconds | 175.629880  |
| FastRoute\GroupCountBased_Benchmark        | benchLast    | bitbucket | 178     | 1.027954 seconds | 173.159482  |
| FastRoute\GroupCountBased_Benchmark        | benchLongest | bitbucket | 178     | 1.028760 seconds | 173.023842  |
| FastRoute\MarkBased_Benchmark              | benchSetup   | bitbucket | 178     | 1.031144 seconds | 172.623780  |
| FastRoute\GroupPosBased_Benchmark          | benchSetup   | bitbucket | 178     | 1.031581 seconds | 172.550650  |
| FastRoute\GroupPosBased_Benchmark          | benchAll     | bitbucket | 178     | 1.038712 seconds | 171.366072  |
| FastRoute\GroupPosBased_Benchmark          | benchLongest | bitbucket | 178     | 1.044326 seconds | 170.444850  |
| FastRoute\CharCountBased_Benchmark         | benchLast    | bitbucket | 178     | 1.046004 seconds | 170.171463  |
| FastRoute\GroupPosBased_Benchmark          | benchLast    | bitbucket | 178     | 1.067736 seconds | 166.707852  |
| FastRoute\MarkBased_Benchmark              | benchAll     | bitbucket | 178     | 1.070176 seconds | 166.327762  |
| Symfony\UrlMatcher_Benchmark               | benchLongest | bitbucket | 178     | 1.393380 seconds | 127.746902  |
| Symfony\UrlMatcher_Benchmark               | benchLast    | bitbucket | 178     | 2.211703 seconds | 80.480966   |
+--------------------------------------------+--------------+-----------+---------+------------------+-------------+
```

## PHP 7.4
```
+--------------------------------------------+--------------+-----------+---------+------------------+-------------+
| Class                                      | Case         | Provider  | Repeats | Time             | Per Second  |
+--------------------------------------------+--------------+-----------+---------+------------------+-------------+
| FastRoute\MarkBased_Cached_Benchmark       | benchSetup   | bitbucket | 178     | 0.065412 seconds | 2721.211381 |
| FastRoute\MarkBased_Cached_Benchmark       | benchAll     | bitbucket | 178     | 0.067657 seconds | 2630.917956 |
| FastRoute\GroupPosBased_Cached_Benchmark   | benchSetup   | bitbucket | 178     | 0.067928 seconds | 2620.418699 |
| FastRoute\GroupCountBased_Cached_Benchmark | benchSetup   | bitbucket | 178     | 0.068302 seconds | 2606.076229 |
| FastRoute\MarkBased_Cached_Benchmark       | benchLongest | bitbucket | 178     | 0.069330 seconds | 2567.423148 |
| FastRoute\CharCountBased_Cached_Benchmark  | benchSetup   | bitbucket | 178     | 0.069709 seconds | 2553.470000 |
| FastRoute\MarkBased_Cached_Benchmark       | benchLast    | bitbucket | 178     | 0.070297 seconds | 2532.113645 |
| FastRoute\GroupCountBased_Cached_Benchmark | benchAll     | bitbucket | 178     | 0.070483 seconds | 2525.432765 |
| FastRoute\GroupPosBased_Cached_Benchmark   | benchAll     | bitbucket | 178     | 0.070509 seconds | 2524.501961 |
| FastRoute\CharCountBased_Cached_Benchmark  | benchAll     | bitbucket | 178     | 0.072330 seconds | 2460.942968 |
| FastRoute\GroupCountBased_Cached_Benchmark | benchLongest | bitbucket | 178     | 0.072880 seconds | 2442.370026 |
| FastRoute\GroupPosBased_Cached_Benchmark   | benchLongest | bitbucket | 178     | 0.072978 seconds | 2439.090574 |
| FastRoute\CharCountBased_Cached_Benchmark  | benchLongest | bitbucket | 178     | 0.073903 seconds | 2408.559844 |
| FastRoute\GroupPosBased_Cached_Benchmark   | benchLast    | bitbucket | 178     | 0.073917 seconds | 2408.101487 |
| FastRoute\GroupCountBased_Cached_Benchmark | benchLast    | bitbucket | 178     | 0.074947 seconds | 2375.015467 |
| FastRoute\CharCountBased_Cached_Benchmark  | benchLast    | bitbucket | 178     | 0.075060 seconds | 2371.432104 |
| Symfony\CompiledUrlMatcher_Benchmark       | benchSetup   | bitbucket | 178     | 0.140612 seconds | 1265.893674 |
| Symfony\CompiledUrlMatcher_Benchmark       | benchLast    | bitbucket | 178     | 0.143602 seconds | 1239.537965 |
| Symfony\CompiledUrlMatcher_Benchmark       | benchLongest | bitbucket | 178     | 0.144256 seconds | 1233.916497 |
| Symfony\CompiledUrlMatcher_Benchmark       | benchAll     | bitbucket | 178     | 0.145600 seconds | 1222.526797 |
| Symfony\UrlMatcher_Benchmark               | benchSetup   | bitbucket | 178     | 0.328841 seconds | 541.295081  |
| Symfony\UrlMatcher_Benchmark               | benchAll     | bitbucket | 178     | 0.343970 seconds | 517.486899  |
| FastRoute\MarkBased_Benchmark              | benchAll     | bitbucket | 178     | 0.751313 seconds | 236.918577  |
| FastRoute\MarkBased_Benchmark              | benchSetup   | bitbucket | 178     | 0.751613 seconds | 236.824035  |
| FastRoute\GroupPosBased_Benchmark          | benchAll     | bitbucket | 178     | 0.753941 seconds | 236.092801  |
| FastRoute\GroupPosBased_Benchmark          | benchSetup   | bitbucket | 178     | 0.755687 seconds | 235.547258  |
| FastRoute\MarkBased_Benchmark              | benchLongest | bitbucket | 178     | 0.757336 seconds | 235.034414  |
| FastRoute\CharCountBased_Benchmark         | benchAll     | bitbucket | 178     | 0.762074 seconds | 233.573120  |
| FastRoute\CharCountBased_Benchmark         | benchSetup   | bitbucket | 178     | 0.764408 seconds | 232.859905  |
| FastRoute\GroupPosBased_Benchmark          | benchLast    | bitbucket | 178     | 0.769351 seconds | 231.363836  |
| FastRoute\CharCountBased_Benchmark         | benchLongest | bitbucket | 178     | 0.770408 seconds | 231.046432  |
| FastRoute\MarkBased_Benchmark              | benchLast    | bitbucket | 178     | 0.771436 seconds | 230.738526  |
| FastRoute\GroupPosBased_Benchmark          | benchLongest | bitbucket | 178     | 0.771940 seconds | 230.587872  |
| FastRoute\GroupCountBased_Benchmark        | benchSetup   | bitbucket | 178     | 0.772669 seconds | 230.370362  |
| FastRoute\GroupCountBased_Benchmark        | benchLongest | bitbucket | 178     | 0.784240 seconds | 226.971333  |
| FastRoute\CharCountBased_Benchmark         | benchLast    | bitbucket | 178     | 0.784741 seconds | 226.826383  |
| FastRoute\GroupCountBased_Benchmark        | benchLast    | bitbucket | 178     | 0.789077 seconds | 225.580001  |
| FastRoute\GroupCountBased_Benchmark        | benchAll     | bitbucket | 178     | 0.790890 seconds | 225.062910  |
| Symfony\UrlMatcher_Benchmark               | benchLongest | bitbucket | 178     | 1.066783 seconds | 166.856810  |
| Symfony\UrlMatcher_Benchmark               | benchLast    | bitbucket | 178     | 1.749295 seconds | 101.755279  |
+--------------------------------------------+--------------+-----------+---------+------------------+-------------+
```

## PHP 8.0
```
+--------------------------------------------+--------------+-----------+---------+------------------+-------------+
| Class                                      | Case         | Provider  | Repeats | Time             | Per Second  |
+--------------------------------------------+--------------+-----------+---------+------------------+-------------+
| FastRoute\MarkBased_Cached_Benchmark       | benchSetup   | bitbucket | 178     | 0.070189 seconds | 2536.009946 |
| FastRoute\GroupPosBased_Cached_Benchmark   | benchSetup   | bitbucket | 178     | 0.072320 seconds | 2461.283716 |
| FastRoute\MarkBased_Cached_Benchmark       | benchAll     | bitbucket | 178     | 0.072575 seconds | 2452.640142 |
| FastRoute\GroupCountBased_Cached_Benchmark | benchSetup   | bitbucket | 178     | 0.072962 seconds | 2439.632552 |
| FastRoute\MarkBased_Cached_Benchmark       | benchLongest | bitbucket | 178     | 0.073775 seconds | 2412.739709 |
| FastRoute\MarkBased_Cached_Benchmark       | benchLast    | bitbucket | 178     | 0.074683 seconds | 2383.408766 |
| FastRoute\GroupPosBased_Cached_Benchmark   | benchAll     | bitbucket | 178     | 0.075156 seconds | 2368.407884 |
| FastRoute\CharCountBased_Cached_Benchmark  | benchSetup   | bitbucket | 178     | 0.075293 seconds | 2364.103065 |
| FastRoute\GroupCountBased_Cached_Benchmark | benchAll     | bitbucket | 178     | 0.075790 seconds | 2348.597019 |
| FastRoute\GroupPosBased_Cached_Benchmark   | benchLongest | bitbucket | 178     | 0.077365 seconds | 2300.777249 |
| FastRoute\GroupCountBased_Cached_Benchmark | benchLongest | bitbucket | 178     | 0.077727 seconds | 2290.064176 |
| FastRoute\CharCountBased_Cached_Benchmark  | benchAll     | bitbucket | 178     | 0.077771 seconds | 2288.765380 |
| FastRoute\GroupPosBased_Cached_Benchmark   | benchLast    | bitbucket | 178     | 0.078197 seconds | 2276.302090 |
| FastRoute\GroupCountBased_Cached_Benchmark | benchLast    | bitbucket | 178     | 0.079188 seconds | 2247.812247 |
| FastRoute\CharCountBased_Cached_Benchmark  | benchLongest | bitbucket | 178     | 0.079492 seconds | 2239.216446 |
| FastRoute\CharCountBased_Cached_Benchmark  | benchLast    | bitbucket | 178     | 0.080400 seconds | 2213.924056 |
| Symfony\CompiledUrlMatcher_Benchmark       | benchSetup   | bitbucket | 178     | 0.139863 seconds | 1272.673844 |
| Symfony\CompiledUrlMatcher_Benchmark       | benchLast    | bitbucket | 178     | 0.142654 seconds | 1247.774841 |
| Symfony\CompiledUrlMatcher_Benchmark       | benchLongest | bitbucket | 178     | 0.142868 seconds | 1245.904945 |
| Symfony\CompiledUrlMatcher_Benchmark       | benchAll     | bitbucket | 178     | 0.144492 seconds | 1231.900839 |
| Symfony\UrlMatcher_Benchmark               | benchSetup   | bitbucket | 178     | 0.332425 seconds | 535.459321  |
| Symfony\UrlMatcher_Benchmark               | benchAll     | bitbucket | 178     | 0.343478 seconds | 518.228295  |
| FastRoute\MarkBased_Benchmark              | benchAll     | bitbucket | 178     | 0.771896 seconds | 230.601048  |
| FastRoute\MarkBased_Benchmark              | benchLongest | bitbucket | 178     | 0.772454 seconds | 230.434427  |
| FastRoute\CharCountBased_Benchmark         | benchSetup   | bitbucket | 178     | 0.775360 seconds | 229.570748  |
| FastRoute\MarkBased_Benchmark              | benchLast    | bitbucket | 178     | 0.776187 seconds | 229.326197  |
| FastRoute\CharCountBased_Benchmark         | benchAll     | bitbucket | 178     | 0.778871 seconds | 228.535902  |
| FastRoute\MarkBased_Benchmark              | benchSetup   | bitbucket | 178     | 0.781737 seconds | 227.698106  |
| FastRoute\GroupPosBased_Benchmark          | benchSetup   | bitbucket | 178     | 0.783551 seconds | 227.170855  |
| FastRoute\CharCountBased_Benchmark         | benchLast    | bitbucket | 178     | 0.783714 seconds | 227.123654  |
| FastRoute\GroupPosBased_Benchmark          | benchLast    | bitbucket | 178     | 0.788668 seconds | 225.697022  |
| FastRoute\CharCountBased_Benchmark         | benchLongest | bitbucket | 178     | 0.789773 seconds | 225.381221  |
| FastRoute\GroupCountBased_Benchmark        | benchSetup   | bitbucket | 178     | 0.790632 seconds | 225.136344  |
| FastRoute\GroupPosBased_Benchmark          | benchLongest | bitbucket | 178     | 0.791760 seconds | 224.815610  |
| FastRoute\GroupPosBased_Benchmark          | benchAll     | bitbucket | 178     | 0.791839 seconds | 224.793204  |
| FastRoute\GroupCountBased_Benchmark        | benchLast    | bitbucket | 178     | 0.798303 seconds | 222.972946  |
| FastRoute\GroupCountBased_Benchmark        | benchAll     | bitbucket | 178     | 0.799618 seconds | 222.606293  |
| FastRoute\GroupCountBased_Benchmark        | benchLongest | bitbucket | 178     | 0.801511 seconds | 222.080532  |
| Symfony\UrlMatcher_Benchmark               | benchLongest | bitbucket | 178     | 0.993070 seconds | 179.242168  |
| Symfony\UrlMatcher_Benchmark               | benchLast    | bitbucket | 178     | 1.614889 seconds | 110.224300  |
+--------------------------------------------+--------------+-----------+---------+------------------+-------------+
```
