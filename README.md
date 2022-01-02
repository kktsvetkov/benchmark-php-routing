# Benchmark PHP Routing

Take a real world routing scenario in the form of a real API and benchmark PHP
routing packages against it.

The APIs used for this benchmark:

* [Bitbucket API](https://api.bitbucket.org/swagger.json)
* [Avalara Avatax API](https://rest.avatax.com/swagger/v2/swagger.json)

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

## Route Provider: Avatax API

The routes for this benchmark provider are read from this address:
https://rest.avatax.com/swagger/v2/swagger.json

You can see the list of paths in [routes/provider/avatax](routes/provider/avatax):

```
/api/v2/accounts
/api/v2/accounts/{id}
/api/v2/accounts/{id}/activate
/api/v2/accounts/{id}/audit
/api/v2/accounts/{id}/configuration
/api/v2/accounts/{id}/licensekey
/api/v2/accounts/{id}/licensekey/{licensekeyname}
/api/v2/accounts/{id}/licensekeys
/api/v2/accounts/{id}/resetlicensekey
/api/v2/addresses/resolve
...
```

# Results

Here are the results from the benchmarks executed by Github Actions:

https://github.com/kktsvetkov/benchmark-php-routing/actions

## PHP 7.3
```
+--------------------------------------------+--------------+-----------------+---------+------------+
| Benchmark                                  | Case         | Provider Routes | Seconds | Per Second |
+--------------------------------------------+--------------+-----------------+---------+------------+
| FastRoute\MarkBased_Cached_Benchmark       | benchSetup   | 178 (bitbucket) | 0.06634 | 2682.94616 |
| FastRoute\GroupPosBased_Cached_Benchmark   | benchSetup   | 178 (bitbucket) | 0.06851 | 2598.12257 |
| FastRoute\GroupCountBased_Cached_Benchmark | benchSetup   | 178 (bitbucket) | 0.06903 | 2578.66744 |
| FastRoute\MarkBased_Cached_Benchmark       | benchAll     | 178 (bitbucket) | 0.06916 | 2573.55631 |
| FastRoute\MarkBased_Cached_Benchmark       | benchLongest | 178 (bitbucket) | 0.07096 | 2508.63088 |
| FastRoute\CharCountBased_Cached_Benchmark  | benchSetup   | 178 (bitbucket) | 0.07118 | 2500.70712 |
| FastRoute\GroupPosBased_Cached_Benchmark   | benchAll     | 178 (bitbucket) | 0.07192 | 2474.99962 |
| FastRoute\MarkBased_Cached_Benchmark       | benchLast    | 178 (bitbucket) | 0.07202 | 2471.43565 |
| FastRoute\GroupCountBased_Cached_Benchmark | benchAll     | 178 (bitbucket) | 0.07217 | 2466.47145 |
| FastRoute\GroupPosBased_Cached_Benchmark   | benchLongest | 178 (bitbucket) | 0.07424 | 2397.69190 |
| FastRoute\CharCountBased_Cached_Benchmark  | benchAll     | 178 (bitbucket) | 0.07424 | 2397.66110 |
| FastRoute\GroupCountBased_Cached_Benchmark | benchLongest | 178 (bitbucket) | 0.07447 | 2390.19225 |
| FastRoute\GroupPosBased_Cached_Benchmark   | benchLast    | 178 (bitbucket) | 0.07545 | 2359.09057 |
| FastRoute\GroupCountBased_Cached_Benchmark | benchLast    | 178 (bitbucket) | 0.07597 | 2343.06157 |
| FastRoute\CharCountBased_Cached_Benchmark  | benchLongest | 178 (bitbucket) | 0.07657 | 2324.58234 |
| FastRoute\CharCountBased_Cached_Benchmark  | benchLast    | 178 (bitbucket) | 0.07768 | 2291.59654 |
| Symfony\CompiledUrlMatcher_Benchmark       | benchSetup   | 178 (bitbucket) | 0.13873 | 1283.08501 |
| Symfony\CompiledUrlMatcher_Benchmark       | benchLast    | 178 (bitbucket) | 0.14057 | 1266.25652 |
| Symfony\CompiledUrlMatcher_Benchmark       | benchLongest | 178 (bitbucket) | 0.14136 | 1259.19810 |
| Symfony\CompiledUrlMatcher_Benchmark       | benchAll     | 178 (bitbucket) | 0.14252 | 1248.93750 |
| Symfony\UrlMatcher_Benchmark               | benchSetup   | 178 (bitbucket) | 0.36063 | 493.580629 |
| Symfony\UrlMatcher_Benchmark               | benchAll     | 178 (bitbucket) | 0.39131 | 454.882345 |
| FastRoute\MarkBased_Benchmark              | benchSetup   | 178 (bitbucket) | 0.82803 | 214.969142 |
| FastRoute\MarkBased_Benchmark              | benchLongest | 178 (bitbucket) | 0.83322 | 213.628502 |
| FastRoute\GroupPosBased_Benchmark          | benchSetup   | 178 (bitbucket) | 0.83924 | 212.097664 |
| FastRoute\CharCountBased_Benchmark         | benchAll     | 178 (bitbucket) | 0.84339 | 211.052776 |
| FastRoute\MarkBased_Benchmark              | benchAll     | 178 (bitbucket) | 0.84361 | 210.998974 |
| FastRoute\GroupPosBased_Benchmark          | benchAll     | 178 (bitbucket) | 0.84673 | 210.219490 |
| FastRoute\CharCountBased_Benchmark         | benchLast    | 178 (bitbucket) | 0.84752 | 210.024514 |
| FastRoute\MarkBased_Benchmark              | benchLast    | 178 (bitbucket) | 0.84879 | 209.709073 |
| FastRoute\GroupPosBased_Benchmark          | benchLongest | 178 (bitbucket) | 0.85147 | 209.050934 |
| FastRoute\CharCountBased_Benchmark         | benchSetup   | 178 (bitbucket) | 0.85227 | 208.855197 |
| FastRoute\GroupPosBased_Benchmark          | benchLast    | 178 (bitbucket) | 0.85244 | 208.813314 |
| FastRoute\CharCountBased_Benchmark         | benchLongest | 178 (bitbucket) | 0.85774 | 207.522110 |
| FastRoute\GroupCountBased_Benchmark        | benchLongest | 178 (bitbucket) | 0.85956 | 207.082230 |
| FastRoute\GroupCountBased_Benchmark        | benchSetup   | 178 (bitbucket) | 0.86573 | 205.605855 |
| FastRoute\GroupCountBased_Benchmark        | benchLast    | 178 (bitbucket) | 0.87033 | 204.520102 |
| FastRoute\GroupCountBased_Benchmark        | benchAll     | 178 (bitbucket) | 0.87985 | 202.306957 |
| Symfony\UrlMatcher_Benchmark               | benchLongest | 178 (bitbucket) | 1.16875 | 152.299459 |
| Symfony\UrlMatcher_Benchmark               | benchLast    | 178 (bitbucket) | 1.88858 | 94.2509168 |
+--------------------------------------------+--------------+-----------------+---------+------------+
```

## PHP 7.4
```
+--------------------------------------------+--------------+-----------------+---------+------------+
| Benchmark                                  | Case         | Provider Routes | Seconds | Per Second |
+--------------------------------------------+--------------+-----------------+---------+------------+
| FastRoute\MarkBased_Cached_Benchmark       | benchSetup   | 178 (bitbucket) | 0.07613 | 2338.22569 |
| FastRoute\MarkBased_Cached_Benchmark       | benchAll     | 178 (bitbucket) | 0.08012 | 2221.61220 |
| FastRoute\GroupPosBased_Cached_Benchmark   | benchSetup   | 178 (bitbucket) | 0.08021 | 2219.20186 |
| FastRoute\GroupCountBased_Cached_Benchmark | benchSetup   | 178 (bitbucket) | 0.08027 | 2217.38272 |
| FastRoute\CharCountBased_Cached_Benchmark  | benchSetup   | 178 (bitbucket) | 0.08178 | 2176.68031 |
| FastRoute\CharCountBased_Cached_Benchmark  | benchAll     | 178 (bitbucket) | 0.08196 | 2171.86791 |
| FastRoute\MarkBased_Cached_Benchmark       | benchLongest | 178 (bitbucket) | 0.08232 | 2162.26909 |
| FastRoute\MarkBased_Cached_Benchmark       | benchLast    | 178 (bitbucket) | 0.08261 | 2154.67454 |
| FastRoute\GroupCountBased_Cached_Benchmark | benchAll     | 178 (bitbucket) | 0.08311 | 2141.66371 |
| FastRoute\GroupCountBased_Cached_Benchmark | benchLongest | 178 (bitbucket) | 0.08617 | 2065.61081 |
| FastRoute\GroupPosBased_Cached_Benchmark   | benchLast    | 178 (bitbucket) | 0.08666 | 2053.91026 |
| FastRoute\GroupPosBased_Cached_Benchmark   | benchAll     | 178 (bitbucket) | 0.08794 | 2024.01457 |
| FastRoute\CharCountBased_Cached_Benchmark  | benchLongest | 178 (bitbucket) | 0.08807 | 2021.09961 |
| FastRoute\GroupCountBased_Cached_Benchmark | benchLast    | 178 (bitbucket) | 0.08899 | 2000.24678 |
| FastRoute\CharCountBased_Cached_Benchmark  | benchLast    | 178 (bitbucket) | 0.08918 | 1995.94204 |
| FastRoute\GroupPosBased_Cached_Benchmark   | benchLongest | 178 (bitbucket) | 0.09325 | 1908.80251 |
| Symfony\CompiledUrlMatcher_Benchmark       | benchSetup   | 178 (bitbucket) | 0.16436 | 1082.96783 |
| Symfony\CompiledUrlMatcher_Benchmark       | benchLast    | 178 (bitbucket) | 0.16636 | 1069.96784 |
| Symfony\CompiledUrlMatcher_Benchmark       | benchLongest | 178 (bitbucket) | 0.16921 | 1051.95347 |
| Symfony\CompiledUrlMatcher_Benchmark       | benchAll     | 178 (bitbucket) | 0.17628 | 1009.76937 |
| Symfony\UrlMatcher_Benchmark               | benchSetup   | 178 (bitbucket) | 0.37880 | 469.901223 |
| Symfony\UrlMatcher_Benchmark               | benchAll     | 178 (bitbucket) | 0.42232 | 421.483355 |
| FastRoute\MarkBased_Benchmark              | benchSetup   | 178 (bitbucket) | 0.87831 | 202.661938 |
| FastRoute\GroupPosBased_Benchmark          | benchSetup   | 178 (bitbucket) | 0.88262 | 201.671618 |
| FastRoute\MarkBased_Benchmark              | benchAll     | 178 (bitbucket) | 0.88393 | 201.372984 |
| FastRoute\MarkBased_Benchmark              | benchLast    | 178 (bitbucket) | 0.89192 | 199.570141 |
| FastRoute\CharCountBased_Benchmark         | benchLast    | 178 (bitbucket) | 0.89406 | 199.092231 |
| FastRoute\CharCountBased_Benchmark         | benchAll     | 178 (bitbucket) | 0.89433 | 199.030769 |
| FastRoute\GroupPosBased_Benchmark          | benchAll     | 178 (bitbucket) | 0.89516 | 198.846930 |
| FastRoute\GroupPosBased_Benchmark          | benchLast    | 178 (bitbucket) | 0.89643 | 198.565628 |
| FastRoute\CharCountBased_Benchmark         | benchLongest | 178 (bitbucket) | 0.89938 | 197.913653 |
| FastRoute\MarkBased_Benchmark              | benchLongest | 178 (bitbucket) | 0.90075 | 197.613065 |
| FastRoute\GroupCountBased_Benchmark        | benchSetup   | 178 (bitbucket) | 0.90815 | 196.003489 |
| FastRoute\GroupPosBased_Benchmark          | benchLongest | 178 (bitbucket) | 0.91043 | 195.511815 |
| FastRoute\CharCountBased_Benchmark         | benchSetup   | 178 (bitbucket) | 0.91374 | 194.804603 |
| FastRoute\GroupCountBased_Benchmark        | benchAll     | 178 (bitbucket) | 0.92081 | 193.307868 |
| FastRoute\GroupCountBased_Benchmark        | benchLast    | 178 (bitbucket) | 0.92835 | 191.737641 |
| FastRoute\GroupCountBased_Benchmark        | benchLongest | 178 (bitbucket) | 0.94425 | 188.509425 |
| Symfony\UrlMatcher_Benchmark               | benchLongest | 178 (bitbucket) | 1.24781 | 142.650480 |
| Symfony\UrlMatcher_Benchmark               | benchLast    | 178 (bitbucket) | 1.98743 | 89.5629092 |
+--------------------------------------------+--------------+-----------------+---------+------------+
```

## PHP 8.0
```
+--------------------------------------------+--------------+-----------------+---------+------------+
| Benchmark                                  | Case         | Provider Routes | Seconds | Per Second |
+--------------------------------------------+--------------+-----------------+---------+------------+
| FastRoute\MarkBased_Cached_Benchmark       | benchSetup   | 178 (bitbucket) | 0.06158 | 2890.69706 |
| FastRoute\GroupCountBased_Cached_Benchmark | benchSetup   | 178 (bitbucket) | 0.06360 | 2798.83378 |
| FastRoute\MarkBased_Cached_Benchmark       | benchAll     | 178 (bitbucket) | 0.06392 | 2784.64690 |
| FastRoute\GroupPosBased_Cached_Benchmark   | benchSetup   | 178 (bitbucket) | 0.06429 | 2768.91793 |
| FastRoute\MarkBased_Cached_Benchmark       | benchLast    | 178 (bitbucket) | 0.06486 | 2744.28732 |
| FastRoute\MarkBased_Cached_Benchmark       | benchLongest | 178 (bitbucket) | 0.06539 | 2721.96539 |
| FastRoute\GroupCountBased_Cached_Benchmark | benchAll     | 178 (bitbucket) | 0.06601 | 2696.72677 |
| FastRoute\CharCountBased_Cached_Benchmark  | benchSetup   | 178 (bitbucket) | 0.06643 | 2679.35470 |
| FastRoute\GroupCountBased_Cached_Benchmark | benchLongest | 178 (bitbucket) | 0.06802 | 2617.02927 |
| FastRoute\GroupPosBased_Cached_Benchmark   | benchAll     | 178 (bitbucket) | 0.06817 | 2611.04349 |
| FastRoute\GroupPosBased_Cached_Benchmark   | benchLast    | 178 (bitbucket) | 0.06900 | 2579.60297 |
| FastRoute\GroupPosBased_Cached_Benchmark   | benchLongest | 178 (bitbucket) | 0.06920 | 2572.07565 |
| FastRoute\CharCountBased_Cached_Benchmark  | benchLast    | 178 (bitbucket) | 0.07152 | 2488.95223 |
| FastRoute\GroupCountBased_Cached_Benchmark | benchLast    | 178 (bitbucket) | 0.07294 | 2440.46990 |
| FastRoute\CharCountBased_Cached_Benchmark  | benchAll     | 178 (bitbucket) | 0.08191 | 2173.03739 |
| FastRoute\CharCountBased_Cached_Benchmark  | benchLongest | 178 (bitbucket) | 0.08217 | 2166.13990 |
| Symfony\CompiledUrlMatcher_Benchmark       | benchSetup   | 178 (bitbucket) | 0.12477 | 1426.62583 |
| Symfony\CompiledUrlMatcher_Benchmark       | benchLast    | 178 (bitbucket) | 0.12652 | 1406.86128 |
| Symfony\CompiledUrlMatcher_Benchmark       | benchAll     | 178 (bitbucket) | 0.14771 | 1205.05744 |
| Symfony\CompiledUrlMatcher_Benchmark       | benchLongest | 178 (bitbucket) | 0.15014 | 1185.55977 |
| Symfony\UrlMatcher_Benchmark               | benchSetup   | 178 (bitbucket) | 0.29099 | 611.694605 |
| Symfony\UrlMatcher_Benchmark               | benchAll     | 178 (bitbucket) | 0.37049 | 480.448739 |
| FastRoute\GroupPosBased_Benchmark          | benchLongest | 178 (bitbucket) | 0.68259 | 260.772654 |
| FastRoute\GroupPosBased_Benchmark          | benchSetup   | 178 (bitbucket) | 0.68405 | 260.214864 |
| FastRoute\MarkBased_Benchmark              | benchLongest | 178 (bitbucket) | 0.68445 | 260.064307 |
| FastRoute\MarkBased_Benchmark              | benchAll     | 178 (bitbucket) | 0.68485 | 259.911752 |
| FastRoute\CharCountBased_Benchmark         | benchSetup   | 178 (bitbucket) | 0.69000 | 257.971795 |
| FastRoute\MarkBased_Benchmark              | benchSetup   | 178 (bitbucket) | 0.69303 | 256.842740 |
| FastRoute\GroupPosBased_Benchmark          | benchLast    | 178 (bitbucket) | 0.69314 | 256.801571 |
| FastRoute\GroupCountBased_Benchmark        | benchLast    | 178 (bitbucket) | 0.69999 | 254.288988 |
| FastRoute\GroupCountBased_Benchmark        | benchAll     | 178 (bitbucket) | 0.70410 | 252.803239 |
| FastRoute\GroupCountBased_Benchmark        | benchLongest | 178 (bitbucket) | 0.70586 | 252.175369 |
| FastRoute\MarkBased_Benchmark              | benchLast    | 178 (bitbucket) | 0.71268 | 249.762848 |
| FastRoute\GroupPosBased_Benchmark          | benchAll     | 178 (bitbucket) | 0.72456 | 245.665681 |
| FastRoute\GroupCountBased_Benchmark        | benchSetup   | 178 (bitbucket) | 0.75150 | 236.860550 |
| FastRoute\CharCountBased_Benchmark         | benchLongest | 178 (bitbucket) | 0.77894 | 228.516245 |
| FastRoute\CharCountBased_Benchmark         | benchLast    | 178 (bitbucket) | 0.79545 | 223.771574 |
| FastRoute\CharCountBased_Benchmark         | benchAll     | 178 (bitbucket) | 0.80367 | 221.482844 |
| Symfony\UrlMatcher_Benchmark               | benchLongest | 178 (bitbucket) | 1.06307 | 167.439425 |
| Symfony\UrlMatcher_Benchmark               | benchLast    | 178 (bitbucket) | 1.42155 | 125.215157 |
+--------------------------------------------+--------------+-----------------+---------+------------+
```
