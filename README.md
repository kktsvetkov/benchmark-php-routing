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

Here are the results from the quick benchmarks executed by Github Actions:

https://github.com/kktsvetkov/benchmark-php-routing/actions

## PHP 7.3
```
+----------------------------------+--------------+-----------------+---------+------------+
| Benchmark                        | Case         | Provider Routes | Seconds | Per Second |
+----------------------------------+--------------+-----------------+---------+------------+
| FastRoute\MarkBased_Cached       | benchSetup   | 256 (avatax)    | 0.00162 | 158415.730 |
| FastRoute\GroupPosBased_Cached   | benchSetup   | 256 (avatax)    | 0.00175 | 146107.201 |
| FastRoute\CharCountBased_Cached  | benchSetup   | 256 (avatax)    | 0.00182 | 141040.565 |
| FastRoute\GroupCountBased_Cached | benchSetup   | 256 (avatax)    | 0.00202 | 126605.568 |
| FastRoute\MarkBased_Cached       | benchSetup   | 178 (bitbucket) | 0.00152 | 116800.080 |
| FastRoute\CharCountBased_Cached  | benchSetup   | 178 (bitbucket) | 0.00154 | 115356.321 |
| FastRoute\GroupCountBased_Cached | benchSetup   | 178 (bitbucket) | 0.00161 | 110490.766 |
| FastRoute\GroupPosBased_Cached   | benchSetup   | 178 (bitbucket) | 0.00174 | 102538.952 |
| FastRoute\MarkBased_Cached       | benchAll     | 256 (avatax)    | 0.00257 | 99651.2133 |
| FastRoute\CharCountBased_Cached  | benchAll     | 256 (avatax)    | 0.00263 | 97303.2917 |
| FastRoute\GroupPosBased_Cached   | benchAll     | 256 (avatax)    | 0.00263 | 97259.2231 |
| FastRoute\GroupCountBased_Cached | benchAll     | 256 (avatax)    | 0.00268 | 95375.8948 |
| FastRoute\GroupPosBased_Cached   | benchAll     | 178 (bitbucket) | 0.00202 | 88332.4789 |
| FastRoute\MarkBased_Cached       | benchAll     | 178 (bitbucket) | 0.00204 | 87381.3333 |
| FastRoute\CharCountBased_Cached  | benchAll     | 178 (bitbucket) | 0.00204 | 87126.3988 |
| FastRoute\GroupCountBased_Cached | benchAll     | 178 (bitbucket) | 0.00224 | 79432.5047 |
| FastRoute\MarkBased_Cached       | benchLongest | 256 (avatax)    | 0.00343 | 74700.2799 |
| FastRoute\MarkBased_Cached       | benchLast    | 256 (avatax)    | 0.00344 | 74461.9850 |
| FastRoute\GroupPosBased_Cached   | benchLongest | 256 (avatax)    | 0.00361 | 70953.6657 |
| Symfony\CompiledUrlMatcher       | benchSetup   | 256 (avatax)    | 0.00372 | 68741.4740 |
| FastRoute\CharCountBased_Cached  | benchLast    | 256 (avatax)    | 0.00380 | 67441.8581 |
| FastRoute\GroupPosBased_Cached   | benchLast    | 256 (avatax)    | 0.00386 | 66251.7322 |
| FastRoute\CharCountBased_Cached  | benchLongest | 256 (avatax)    | 0.00388 | 65914.1696 |
| FastRoute\GroupCountBased_Cached | benchLongest | 256 (avatax)    | 0.00403 | 63523.7427 |
| FastRoute\GroupCountBased_Cached | benchLast    | 256 (avatax)    | 0.00433 | 59055.2097 |
| FastRoute\MarkBased_Cached       | benchLongest | 178 (bitbucket) | 0.00307 | 57978.2645 |
| FastRoute\CharCountBased_Cached  | benchLongest | 178 (bitbucket) | 0.00316 | 56346.1216 |
| FastRoute\GroupPosBased_Cached   | benchLongest | 178 (bitbucket) | 0.00316 | 56312.1218 |
| Symfony\CompiledUrlMatcher       | benchAll     | 256 (avatax)    | 0.00464 | 55196.7215 |
| Symfony\CompiledUrlMatcher       | benchSetup   | 178 (bitbucket) | 0.00334 | 53339.0092 |
| FastRoute\MarkBased_Cached       | benchLast    | 178 (bitbucket) | 0.00339 | 52569.0826 |
| FastRoute\GroupCountBased_Cached | benchLongest | 178 (bitbucket) | 0.00339 | 52476.7071 |
| Symfony\CompiledUrlMatcher       | benchLast    | 256 (avatax)    | 0.00490 | 52224.7968 |
| Symfony\CompiledUrlMatcher       | benchLongest | 256 (avatax)    | 0.00496 | 51612.2776 |
| FastRoute\CharCountBased_Cached  | benchLast    | 178 (bitbucket) | 0.00366 | 48593.2121 |
| FastRoute\GroupPosBased_Cached   | benchLast    | 178 (bitbucket) | 0.00373 | 47708.2313 |
| Symfony\CompiledUrlMatcher       | benchAll     | 178 (bitbucket) | 0.00391 | 45581.9104 |
| FastRoute\GroupCountBased_Cached | benchLast    | 178 (bitbucket) | 0.00408 | 43593.7236 |
| Symfony\CompiledUrlMatcher       | benchLast    | 178 (bitbucket) | 0.00438 | 40648.2338 |
| Symfony\CompiledUrlMatcher       | benchLongest | 178 (bitbucket) | 0.00452 | 39345.7766 |
| Symfony\UrlMatcher               | benchSetup   | 178 (bitbucket) | 0.03540 | 5027.95606 |
| Symfony\UrlMatcher               | benchAll     | 178 (bitbucket) | 0.03811 | 4670.80481 |
| Symfony\UrlMatcher               | benchSetup   | 256 (avatax)    | 0.06557 | 3904.28856 |
| Symfony\UrlMatcher               | benchAll     | 256 (avatax)    | 0.07041 | 3636.10505 |
| FastRoute\GroupPosBased          | benchSetup   | 178 (bitbucket) | 0.13409 | 1327.47659 |
| FastRoute\GroupCountBased        | benchSetup   | 178 (bitbucket) | 0.13538 | 1314.78021 |
| FastRoute\MarkBased              | benchSetup   | 178 (bitbucket) | 0.13546 | 1313.99344 |
| FastRoute\MarkBased              | benchAll     | 178 (bitbucket) | 0.13668 | 1302.32212 |
| FastRoute\GroupPosBased          | benchLongest | 178 (bitbucket) | 0.13694 | 1299.84837 |
| FastRoute\GroupCountBased        | benchAll     | 178 (bitbucket) | 0.13696 | 1299.61984 |
| FastRoute\CharCountBased         | benchSetup   | 178 (bitbucket) | 0.13723 | 1297.12253 |
| FastRoute\MarkBased              | benchLast    | 178 (bitbucket) | 0.13728 | 1296.59989 |
| FastRoute\MarkBased              | benchLongest | 178 (bitbucket) | 0.13734 | 1296.06193 |
| FastRoute\GroupPosBased          | benchAll     | 178 (bitbucket) | 0.13741 | 1295.38506 |
| FastRoute\GroupPosBased          | benchLast    | 178 (bitbucket) | 0.13831 | 1286.95338 |
| FastRoute\CharCountBased         | benchAll     | 178 (bitbucket) | 0.13870 | 1283.31659 |
| FastRoute\GroupCountBased        | benchLongest | 178 (bitbucket) | 0.13933 | 1277.50618 |
| FastRoute\GroupCountBased        | benchLast    | 178 (bitbucket) | 0.14174 | 1255.82822 |
| FastRoute\CharCountBased         | benchLongest | 178 (bitbucket) | 0.14222 | 1251.59027 |
| FastRoute\CharCountBased         | benchLast    | 178 (bitbucket) | 0.14245 | 1249.58761 |
| Symfony\UrlMatcher               | benchLongest | 178 (bitbucket) | 0.19409 | 917.123368 |
| Symfony\UrlMatcher               | benchLongest | 256 (avatax)    | 0.31005 | 825.684043 |
| Symfony\UrlMatcher               | benchLast    | 256 (avatax)    | 0.38904 | 658.033260 |
| Symfony\UrlMatcher               | benchLast    | 178 (bitbucket) | 0.31080 | 572.724659 |
| FastRoute\GroupPosBased          | benchSetup   | 256 (avatax)    | 0.66871 | 382.824319 |
| FastRoute\MarkBased              | benchSetup   | 256 (avatax)    | 0.67320 | 380.273247 |
| FastRoute\MarkBased              | benchAll     | 256 (avatax)    | 0.67642 | 378.463633 |
| FastRoute\GroupPosBased          | benchLast    | 256 (avatax)    | 0.67685 | 378.222737 |
| FastRoute\GroupPosBased          | benchAll     | 256 (avatax)    | 0.67712 | 378.071317 |
| FastRoute\GroupPosBased          | benchLongest | 256 (avatax)    | 0.67766 | 377.771766 |
| FastRoute\CharCountBased         | benchAll     | 256 (avatax)    | 0.67964 | 376.670632 |
| FastRoute\CharCountBased         | benchLongest | 256 (avatax)    | 0.67985 | 376.555840 |
| FastRoute\MarkBased              | benchLast    | 256 (avatax)    | 0.68155 | 375.612160 |
| FastRoute\CharCountBased         | benchSetup   | 256 (avatax)    | 0.68233 | 375.182857 |
| FastRoute\MarkBased              | benchLongest | 256 (avatax)    | 0.68293 | 374.855929 |
| FastRoute\CharCountBased         | benchLast    | 256 (avatax)    | 0.68439 | 374.056212 |
| FastRoute\GroupCountBased        | benchSetup   | 256 (avatax)    | 0.77412 | 330.696719 |
| FastRoute\GroupCountBased        | benchLongest | 256 (avatax)    | 0.77589 | 329.944441 |
| FastRoute\GroupCountBased        | benchLast    | 256 (avatax)    | 0.78431 | 326.402003 |
| FastRoute\GroupCountBased        | benchAll     | 256 (avatax)    | 0.78561 | 325.859767 |
+----------------------------------+--------------+-----------------+---------+------------+
```

## PHP 7.4
```
+----------------------------------+--------------+-----------------+---------+------------+
| Benchmark                        | Case         | Provider Routes | Seconds | Per Second |
+----------------------------------+--------------+-----------------+---------+------------+
| FastRoute\GroupCountBased_Cached | benchSetup   | 256 (avatax)    | 0.00178 | 143894.642 |
| FastRoute\MarkBased_Cached       | benchSetup   | 256 (avatax)    | 0.00186 | 137853.617 |
| FastRoute\CharCountBased_Cached  | benchSetup   | 256 (avatax)    | 0.00188 | 136382.805 |
| FastRoute\GroupPosBased_Cached   | benchSetup   | 256 (avatax)    | 0.00189 | 135590.582 |
| FastRoute\MarkBased_Cached       | benchSetup   | 178 (bitbucket) | 0.00146 | 121831.937 |
| FastRoute\GroupPosBased_Cached   | benchSetup   | 178 (bitbucket) | 0.00171 | 104213.583 |
| FastRoute\GroupCountBased_Cached | benchSetup   | 178 (bitbucket) | 0.00177 | 100849.130 |
| FastRoute\CharCountBased_Cached  | benchSetup   | 178 (bitbucket) | 0.00177 | 100388.074 |
| FastRoute\MarkBased_Cached       | benchAll     | 178 (bitbucket) | 0.00190 | 93533.7148 |
| FastRoute\MarkBased_Cached       | benchAll     | 256 (avatax)    | 0.00278 | 91922.0806 |
| FastRoute\GroupCountBased_Cached | benchAll     | 256 (avatax)    | 0.00281 | 91002.7819 |
| FastRoute\GroupPosBased_Cached   | benchAll     | 256 (avatax)    | 0.00282 | 90848.7878 |
| FastRoute\CharCountBased_Cached  | benchAll     | 256 (avatax)    | 0.00299 | 85618.5171 |
| FastRoute\GroupCountBased_Cached | benchAll     | 178 (bitbucket) | 0.00215 | 82898.7466 |
| FastRoute\GroupPosBased_Cached   | benchAll     | 178 (bitbucket) | 0.00216 | 82486.5884 |
| FastRoute\CharCountBased_Cached  | benchAll     | 178 (bitbucket) | 0.00222 | 80286.7095 |
| FastRoute\MarkBased_Cached       | benchLongest | 256 (avatax)    | 0.00366 | 70005.3347 |
| FastRoute\MarkBased_Cached       | benchLast    | 256 (avatax)    | 0.00374 | 68539.6287 |
| FastRoute\CharCountBased_Cached  | benchLongest | 256 (avatax)    | 0.00404 | 63302.7841 |
| FastRoute\GroupPosBased_Cached   | benchLongest | 256 (avatax)    | 0.00406 | 62979.7538 |
| Symfony\CompiledUrlMatcher       | benchSetup   | 256 (avatax)    | 0.00410 | 62499.5240 |
| FastRoute\CharCountBased_Cached  | benchLast    | 256 (avatax)    | 0.00419 | 61025.3949 |
| FastRoute\GroupPosBased_Cached   | benchLast    | 256 (avatax)    | 0.00426 | 60136.7585 |
| FastRoute\MarkBased_Cached       | benchLongest | 178 (bitbucket) | 0.00303 | 58804.8292 |
| FastRoute\GroupCountBased_Cached | benchLongest | 256 (avatax)    | 0.00450 | 56874.9310 |
| FastRoute\MarkBased_Cached       | benchLast    | 178 (bitbucket) | 0.00335 | 53213.5503 |
| FastRoute\GroupCountBased_Cached | benchLast    | 256 (avatax)    | 0.00489 | 52308.7554 |
| FastRoute\CharCountBased_Cached  | benchLongest | 178 (bitbucket) | 0.00350 | 50902.4416 |
| Symfony\CompiledUrlMatcher       | benchAll     | 256 (avatax)    | 0.00509 | 50266.4586 |
| FastRoute\GroupPosBased_Cached   | benchLongest | 178 (bitbucket) | 0.00357 | 49875.4834 |
| Symfony\CompiledUrlMatcher       | benchSetup   | 178 (bitbucket) | 0.00367 | 48489.0635 |
| FastRoute\GroupCountBased_Cached | benchLongest | 178 (bitbucket) | 0.00368 | 48303.9668 |
| Symfony\CompiledUrlMatcher       | benchLast    | 256 (avatax)    | 0.00530 | 48264.5670 |
| Symfony\CompiledUrlMatcher       | benchLongest | 256 (avatax)    | 0.00545 | 46937.4813 |
| FastRoute\CharCountBased_Cached  | benchLast    | 178 (bitbucket) | 0.00397 | 44791.5833 |
| FastRoute\GroupPosBased_Cached   | benchLast    | 178 (bitbucket) | 0.00404 | 44069.7781 |
| Symfony\CompiledUrlMatcher       | benchAll     | 178 (bitbucket) | 0.00419 | 42501.7711 |
| FastRoute\GroupCountBased_Cached | benchLast    | 178 (bitbucket) | 0.00464 | 38327.7433 |
| Symfony\CompiledUrlMatcher       | benchLast    | 178 (bitbucket) | 0.00470 | 37890.0787 |
| Symfony\CompiledUrlMatcher       | benchLongest | 178 (bitbucket) | 0.00628 | 28325.9138 |
| Symfony\UrlMatcher               | benchSetup   | 178 (bitbucket) | 0.03796 | 4688.55103 |
| Symfony\UrlMatcher               | benchAll     | 178 (bitbucket) | 0.04113 | 4327.73437 |
| Symfony\UrlMatcher               | benchSetup   | 256 (avatax)    | 0.06296 | 4065.75622 |
| Symfony\UrlMatcher               | benchAll     | 256 (avatax)    | 0.06668 | 3839.50934 |
| FastRoute\GroupPosBased          | benchSetup   | 178 (bitbucket) | 0.15013 | 1185.63131 |
| FastRoute\GroupPosBased          | benchAll     | 178 (bitbucket) | 0.15039 | 1183.58253 |
| FastRoute\MarkBased              | benchAll     | 178 (bitbucket) | 0.15067 | 1181.41369 |
| FastRoute\MarkBased              | benchSetup   | 178 (bitbucket) | 0.15102 | 1178.65888 |
| FastRoute\GroupCountBased        | benchSetup   | 178 (bitbucket) | 0.15246 | 1167.54963 |
| FastRoute\GroupPosBased          | benchLongest | 178 (bitbucket) | 0.15269 | 1165.75209 |
| FastRoute\MarkBased              | benchLast    | 178 (bitbucket) | 0.15340 | 1160.37269 |
| FastRoute\GroupCountBased        | benchAll     | 178 (bitbucket) | 0.15459 | 1151.45494 |
| FastRoute\GroupPosBased          | benchLast    | 178 (bitbucket) | 0.15460 | 1151.35905 |
| FastRoute\MarkBased              | benchLongest | 178 (bitbucket) | 0.15461 | 1151.27560 |
| FastRoute\GroupCountBased        | benchLongest | 178 (bitbucket) | 0.15596 | 1141.28278 |
| FastRoute\CharCountBased         | benchSetup   | 178 (bitbucket) | 0.15673 | 1135.69082 |
| FastRoute\GroupCountBased        | benchLast    | 178 (bitbucket) | 0.15714 | 1132.78384 |
| FastRoute\CharCountBased         | benchLast    | 178 (bitbucket) | 0.16007 | 1111.98573 |
| FastRoute\CharCountBased         | benchAll     | 178 (bitbucket) | 0.16174 | 1100.56534 |
| FastRoute\CharCountBased         | benchLongest | 178 (bitbucket) | 0.16583 | 1073.36284 |
| Symfony\UrlMatcher               | benchLongest | 178 (bitbucket) | 0.18954 | 939.105571 |
| Symfony\UrlMatcher               | benchLongest | 256 (avatax)    | 0.28847 | 887.440543 |
| Symfony\UrlMatcher               | benchLast    | 256 (avatax)    | 0.36510 | 701.181601 |
| Symfony\UrlMatcher               | benchLast    | 178 (bitbucket) | 0.30805 | 577.826193 |
| FastRoute\CharCountBased         | benchLongest | 256 (avatax)    | 0.66905 | 382.634284 |
| FastRoute\CharCountBased         | benchAll     | 256 (avatax)    | 0.67063 | 381.731709 |
| FastRoute\GroupPosBased          | benchSetup   | 256 (avatax)    | 0.74506 | 343.595514 |
| FastRoute\MarkBased              | benchSetup   | 256 (avatax)    | 0.74836 | 342.079971 |
| FastRoute\MarkBased              | benchAll     | 256 (avatax)    | 0.74992 | 341.370229 |
| FastRoute\GroupCountBased        | benchSetup   | 256 (avatax)    | 0.75175 | 340.539178 |
| FastRoute\CharCountBased         | benchSetup   | 256 (avatax)    | 0.75328 | 339.846565 |
| FastRoute\GroupPosBased          | benchAll     | 256 (avatax)    | 0.75421 | 339.426618 |
| FastRoute\MarkBased              | benchLast    | 256 (avatax)    | 0.75442 | 339.332114 |
| FastRoute\GroupCountBased        | benchAll     | 256 (avatax)    | 0.75485 | 339.139409 |
| FastRoute\GroupPosBased          | benchLast    | 256 (avatax)    | 0.75751 | 337.948400 |
| FastRoute\GroupPosBased          | benchLongest | 256 (avatax)    | 0.75814 | 337.668040 |
| FastRoute\GroupCountBased        | benchLongest | 256 (avatax)    | 0.75834 | 337.579926 |
| FastRoute\MarkBased              | benchLongest | 256 (avatax)    | 0.75839 | 337.556791 |
| FastRoute\GroupCountBased        | benchLast    | 256 (avatax)    | 0.75891 | 337.325398 |
| FastRoute\CharCountBased         | benchLast    | 256 (avatax)    | 0.76150 | 336.178226 |
+----------------------------------+--------------+-----------------+---------+------------+
```

## PHP 8.0
```
+----------------------------------+--------------+-----------------+---------+------------+
| Benchmark                        | Case         | Provider Routes | Seconds | Per Second |
+----------------------------------+--------------+-----------------+---------+------------+
| FastRoute\GroupPosBased_Cached   | benchSetup   | 256 (avatax)    | 0.00245 | 104408.967 |
| FastRoute\GroupCountBased_Cached | benchSetup   | 256 (avatax)    | 0.00256 | 99845.8084 |
| FastRoute\MarkBased_Cached       | benchSetup   | 256 (avatax)    | 0.00257 | 99494.2386 |
| FastRoute\CharCountBased_Cached  | benchSetup   | 256 (avatax)    | 0.00275 | 93158.2356 |
| FastRoute\CharCountBased_Cached  | benchSetup   | 178 (bitbucket) | 0.00199 | 89443.6458 |
| FastRoute\MarkBased_Cached       | benchSetup   | 178 (bitbucket) | 0.00250 | 71198.3703 |
| FastRoute\GroupPosBased_Cached   | benchSetup   | 178 (bitbucket) | 0.00253 | 70379.5354 |
| FastRoute\GroupCountBased_Cached | benchSetup   | 178 (bitbucket) | 0.00258 | 69070.7847 |
| FastRoute\CharCountBased_Cached  | benchAll     | 256 (avatax)    | 0.00402 | 63727.3324 |
| FastRoute\CharCountBased_Cached  | benchAll     | 178 (bitbucket) | 0.00280 | 63571.7057 |
| FastRoute\GroupCountBased_Cached | benchAll     | 256 (avatax)    | 0.00412 | 62091.1249 |
| FastRoute\GroupPosBased_Cached   | benchAll     | 256 (avatax)    | 0.00457 | 56020.3382 |
| FastRoute\CharCountBased_Cached  | benchLast    | 256 (avatax)    | 0.00483 | 53047.8644 |
| FastRoute\MarkBased_Cached       | benchAll     | 256 (avatax)    | 0.00483 | 52948.4601 |
| FastRoute\GroupCountBased_Cached | benchAll     | 178 (bitbucket) | 0.00337 | 52833.2115 |
| Symfony\CompiledUrlMatcher       | benchSetup   | 256 (avatax)    | 0.00494 | 51831.5226 |
| FastRoute\CharCountBased_Cached  | benchLongest | 256 (avatax)    | 0.00501 | 51089.2051 |
| FastRoute\MarkBased_Cached       | benchLongest | 256 (avatax)    | 0.00514 | 49844.1102 |
| FastRoute\GroupCountBased_Cached | benchLongest | 256 (avatax)    | 0.00515 | 49698.7652 |
| FastRoute\GroupPosBased_Cached   | benchAll     | 178 (bitbucket) | 0.00359 | 49583.9883 |
| FastRoute\MarkBased_Cached       | benchAll     | 178 (bitbucket) | 0.00387 | 45957.9016 |
| FastRoute\GroupPosBased_Cached   | benchLongest | 256 (avatax)    | 0.00569 | 44982.9000 |
| FastRoute\GroupCountBased_Cached | benchLast    | 256 (avatax)    | 0.00570 | 44928.3159 |
| FastRoute\GroupPosBased_Cached   | benchLast    | 256 (avatax)    | 0.00574 | 44622.1096 |
| FastRoute\CharCountBased_Cached  | benchLongest | 178 (bitbucket) | 0.00417 | 42696.2205 |
| FastRoute\MarkBased_Cached       | benchLast    | 256 (avatax)    | 0.00613 | 41789.5938 |
| FastRoute\MarkBased_Cached       | benchLongest | 178 (bitbucket) | 0.00435 | 40929.0122 |
| Symfony\CompiledUrlMatcher       | benchSetup   | 178 (bitbucket) | 0.00450 | 39598.2874 |
| FastRoute\GroupPosBased_Cached   | benchLast    | 178 (bitbucket) | 0.00456 | 39069.8682 |
| FastRoute\GroupPosBased_Cached   | benchLongest | 178 (bitbucket) | 0.00456 | 39035.1412 |
| FastRoute\CharCountBased_Cached  | benchLast    | 178 (bitbucket) | 0.00464 | 38347.4298 |
| FastRoute\MarkBased_Cached       | benchLast    | 178 (bitbucket) | 0.00486 | 36595.5645 |
| FastRoute\GroupCountBased_Cached | benchLongest | 178 (bitbucket) | 0.00548 | 32494.1727 |
| Symfony\CompiledUrlMatcher       | benchLast    | 256 (avatax)    | 0.00797 | 32124.8750 |
| Symfony\CompiledUrlMatcher       | benchAll     | 256 (avatax)    | 0.00806 | 31749.6621 |
| FastRoute\GroupCountBased_Cached | benchLast    | 178 (bitbucket) | 0.00583 | 30521.4877 |
| Symfony\CompiledUrlMatcher       | benchLongest | 256 (avatax)    | 0.00893 | 28676.7038 |
| Symfony\CompiledUrlMatcher       | benchLast    | 178 (bitbucket) | 0.00650 | 27371.5395 |
| Symfony\CompiledUrlMatcher       | benchLongest | 178 (bitbucket) | 0.00656 | 27137.7307 |
| Symfony\CompiledUrlMatcher       | benchAll     | 178 (bitbucket) | 0.00713 | 24968.6001 |
| Symfony\UrlMatcher               | benchSetup   | 178 (bitbucket) | 0.03712 | 4794.87564 |
| Symfony\UrlMatcher               | benchSetup   | 256 (avatax)    | 0.07012 | 3650.68058 |
| Symfony\UrlMatcher               | benchAll     | 178 (bitbucket) | 0.04896 | 3635.48147 |
| Symfony\UrlMatcher               | benchAll     | 256 (avatax)    | 0.07226 | 3542.95404 |
| FastRoute\GroupCountBased        | benchSetup   | 178 (bitbucket) | 0.13366 | 1331.73646 |
| FastRoute\MarkBased              | benchSetup   | 178 (bitbucket) | 0.13390 | 1329.36992 |
| FastRoute\GroupPosBased          | benchLongest | 178 (bitbucket) | 0.13566 | 1312.07445 |
| FastRoute\GroupCountBased        | benchLast    | 178 (bitbucket) | 0.13753 | 1294.28243 |
| FastRoute\MarkBased              | benchAll     | 178 (bitbucket) | 0.13756 | 1293.96165 |
| FastRoute\GroupPosBased          | benchSetup   | 178 (bitbucket) | 0.13791 | 1290.72464 |
| FastRoute\MarkBased              | benchLast    | 178 (bitbucket) | 0.13802 | 1289.65889 |
| FastRoute\GroupPosBased          | benchAll     | 178 (bitbucket) | 0.13871 | 1283.26144 |
| FastRoute\GroupPosBased          | benchLast    | 178 (bitbucket) | 0.14163 | 1256.78799 |
| FastRoute\GroupCountBased        | benchAll     | 178 (bitbucket) | 0.14206 | 1252.98291 |
| FastRoute\CharCountBased         | benchLast    | 178 (bitbucket) | 0.14391 | 1236.84172 |
| FastRoute\MarkBased              | benchLongest | 178 (bitbucket) | 0.14714 | 1209.70849 |
| FastRoute\GroupCountBased        | benchLongest | 178 (bitbucket) | 0.14937 | 1191.65492 |
| Symfony\UrlMatcher               | benchLongest | 178 (bitbucket) | 0.15510 | 1147.62471 |
| FastRoute\CharCountBased         | benchLongest | 178 (bitbucket) | 0.15512 | 1147.52064 |
| FastRoute\CharCountBased         | benchSetup   | 178 (bitbucket) | 0.15596 | 1141.28278 |
| FastRoute\CharCountBased         | benchAll     | 178 (bitbucket) | 0.16020 | 1111.07721 |
| Symfony\UrlMatcher               | benchLongest | 256 (avatax)    | 0.29018 | 882.216937 |
| Symfony\UrlMatcher               | benchLast    | 256 (avatax)    | 0.34392 | 744.363297 |
| Symfony\UrlMatcher               | benchLast    | 178 (bitbucket) | 0.26980 | 659.755668 |
| FastRoute\CharCountBased         | benchSetup   | 256 (avatax)    | 0.65860 | 388.704522 |
| FastRoute\GroupPosBased          | benchSetup   | 256 (avatax)    | 0.66391 | 385.593376 |
| FastRoute\GroupPosBased          | benchLongest | 256 (avatax)    | 0.66578 | 384.510810 |
| FastRoute\GroupPosBased          | benchAll     | 256 (avatax)    | 0.66791 | 383.286894 |
| FastRoute\GroupPosBased          | benchLast    | 256 (avatax)    | 0.67170 | 381.121983 |
| FastRoute\CharCountBased         | benchAll     | 256 (avatax)    | 0.67780 | 377.692435 |
| FastRoute\CharCountBased         | benchLast    | 256 (avatax)    | 0.68050 | 376.192903 |
| FastRoute\GroupCountBased        | benchLast    | 256 (avatax)    | 0.68315 | 374.736879 |
| FastRoute\GroupCountBased        | benchSetup   | 256 (avatax)    | 0.68423 | 374.144191 |
| FastRoute\CharCountBased         | benchLongest | 256 (avatax)    | 0.68938 | 371.350388 |
| FastRoute\MarkBased              | benchSetup   | 256 (avatax)    | 0.69827 | 366.620318 |
| FastRoute\GroupCountBased        | benchLongest | 256 (avatax)    | 0.71279 | 359.153019 |
| FastRoute\MarkBased              | benchLast    | 256 (avatax)    | 0.71922 | 355.943202 |
| FastRoute\GroupCountBased        | benchAll     | 256 (avatax)    | 0.72071 | 355.207732 |
| FastRoute\MarkBased              | benchLongest | 256 (avatax)    | 0.73385 | 348.844677 |
| FastRoute\MarkBased              | benchAll     | 256 (avatax)    | 0.77061 | 332.203083 |
+----------------------------------+--------------+-----------------+---------+------------+
```
