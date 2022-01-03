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
| FastRoute\MarkBased_Cached       | benchSetup   | 256 (avatax)    | 0.00186 | 137712.174 |
| FastRoute\GroupPosBased_Cached   | benchSetup   | 256 (avatax)    | 0.00193 | 132446.259 |
| FastRoute\CharCountBased_Cached  | benchSetup   | 256 (avatax)    | 0.00194 | 131893.111 |
| FastRoute\GroupCountBased_Cached | benchSetup   | 256 (avatax)    | 0.00196 | 130419.266 |
| FastRoute\MarkBased_Cached       | benchSetup   | 178 (bitbucket) | 0.00171 | 104228.132 |
| FastRoute\GroupPosBased_Cached   | benchSetup   | 178 (bitbucket) | 0.00173 | 102764.777 |
| FastRoute\GroupCountBased_Cached | benchSetup   | 178 (bitbucket) | 0.00173 | 102764.777 |
| FastRoute\CharCountBased_Cached  | benchSetup   | 178 (bitbucket) | 0.00178 | 100172.562 |
| FastRoute\GroupPosBased_Cached   | benchAll     | 256 (avatax)    | 0.00287 | 89070.2467 |
| FastRoute\MarkBased_Cached       | benchAll     | 256 (avatax)    | 0.00291 | 87910.7437 |
| FastRoute\GroupCountBased_Cached | benchAll     | 256 (avatax)    | 0.00293 | 87281.8910 |
| FastRoute\CharCountBased_Cached  | benchAll     | 256 (avatax)    | 0.00296 | 86487.4606 |
| FastRoute\MarkBased_Cached       | benchAll     | 178 (bitbucket) | 0.00225 | 79213.3805 |
| FastRoute\GroupPosBased_Cached   | benchAll     | 178 (bitbucket) | 0.00225 | 79037.2763 |
| FastRoute\CharCountBased_Cached  | benchAll     | 178 (bitbucket) | 0.00226 | 78762.1175 |
| FastRoute\GroupCountBased_Cached | benchAll     | 178 (bitbucket) | 0.00231 | 77062.9760 |
| FastRoute\MarkBased_Cached       | benchLongest | 256 (avatax)    | 0.00359 | 71368.6822 |
| FastRoute\MarkBased_Cached       | benchLast    | 256 (avatax)    | 0.00380 | 67369.9224 |
| FastRoute\CharCountBased_Cached  | benchLongest | 256 (avatax)    | 0.00394 | 64921.8105 |
| FastRoute\GroupPosBased_Cached   | benchLongest | 256 (avatax)    | 0.00403 | 63463.6694 |
| FastRoute\CharCountBased_Cached  | benchLast    | 256 (avatax)    | 0.00417 | 61391.7566 |
| FastRoute\GroupPosBased_Cached   | benchLast    | 256 (avatax)    | 0.00426 | 60163.7151 |
| FastRoute\GroupCountBased_Cached | benchLongest | 256 (avatax)    | 0.00446 | 57425.4906 |
| FastRoute\MarkBased_Cached       | benchLongest | 178 (bitbucket) | 0.00336 | 53054.7265 |
| FastRoute\CharCountBased_Cached  | benchLongest | 178 (bitbucket) | 0.00342 | 52077.7142 |
| FastRoute\GroupCountBased_Cached | benchLast    | 256 (avatax)    | 0.00492 | 51999.7009 |
| FastRoute\GroupPosBased_Cached   | benchLongest | 178 (bitbucket) | 0.00356 | 50059.4147 |
| FastRoute\GroupCountBased_Cached | benchLongest | 178 (bitbucket) | 0.00363 | 48995.0198 |
| FastRoute\MarkBased_Cached       | benchLast    | 178 (bitbucket) | 0.00378 | 47064.6228 |
| FastRoute\GroupPosBased_Cached   | benchLast    | 178 (bitbucket) | 0.00401 | 44334.0921 |
| FastRoute\CharCountBased_Cached  | benchLast    | 178 (bitbucket) | 0.00404 | 44038.5838 |
| FastRoute\GroupCountBased_Cached | benchLast    | 178 (bitbucket) | 0.00460 | 38661.1833 |
| Symfony\UrlMatcher               | benchSetup   | 178 (bitbucket) | 0.03665 | 4857.29787 |
| Symfony\UrlMatcher               | benchAll     | 178 (bitbucket) | 0.03881 | 4586.67046 |
| Symfony\UrlMatcher               | benchSetup   | 256 (avatax)    | 0.07167 | 3572.12613 |
| Symfony\UrlMatcher               | benchAll     | 256 (avatax)    | 0.07490 | 3417.70959 |
| Symfony\CompiledUrlMatcher       | benchSetup   | 178 (bitbucket) | 0.13794 | 1290.38778 |
| Symfony\CompiledUrlMatcher       | benchLast    | 178 (bitbucket) | 0.14011 | 1270.46698 |
| Symfony\CompiledUrlMatcher       | benchLongest | 178 (bitbucket) | 0.14068 | 1265.24578 |
| Symfony\CompiledUrlMatcher       | benchAll     | 178 (bitbucket) | 0.14184 | 1254.93530 |
| FastRoute\GroupPosBased          | benchSetup   | 178 (bitbucket) | 0.15137 | 1175.91134 |
| FastRoute\MarkBased              | benchSetup   | 178 (bitbucket) | 0.15217 | 1169.72281 |
| FastRoute\MarkBased              | benchAll     | 178 (bitbucket) | 0.15288 | 1164.28136 |
| FastRoute\MarkBased              | benchLongest | 178 (bitbucket) | 0.15517 | 1147.11512 |
| FastRoute\GroupCountBased        | benchSetup   | 178 (bitbucket) | 0.15569 | 1143.26814 |
| FastRoute\MarkBased              | benchLast    | 178 (bitbucket) | 0.15603 | 1140.83633 |
| FastRoute\CharCountBased         | benchSetup   | 178 (bitbucket) | 0.15678 | 1135.32814 |
| FastRoute\GroupPosBased          | benchLongest | 178 (bitbucket) | 0.15734 | 1131.28706 |
| FastRoute\GroupPosBased          | benchAll     | 178 (bitbucket) | 0.15751 | 1130.11575 |
| FastRoute\CharCountBased         | benchAll     | 178 (bitbucket) | 0.15756 | 1129.72243 |
| FastRoute\GroupPosBased          | benchLast    | 178 (bitbucket) | 0.15865 | 1121.95197 |
| FastRoute\GroupCountBased        | benchAll     | 178 (bitbucket) | 0.15953 | 1115.75644 |
| FastRoute\GroupCountBased        | benchLast    | 178 (bitbucket) | 0.16001 | 1112.46459 |
| FastRoute\GroupCountBased        | benchLongest | 178 (bitbucket) | 0.16159 | 1101.58676 |
| FastRoute\CharCountBased         | benchLongest | 178 (bitbucket) | 0.16163 | 1101.26016 |
| FastRoute\CharCountBased         | benchLast    | 178 (bitbucket) | 0.16477 | 1080.26634 |
| Symfony\CompiledUrlMatcher       | benchSetup   | 256 (avatax)    | 0.25569 | 1001.21295 |
| Symfony\CompiledUrlMatcher       | benchLongest | 256 (avatax)    | 0.25922 | 987.589457 |
| Symfony\CompiledUrlMatcher       | benchLast    | 256 (avatax)    | 0.25928 | 987.360606 |
| Symfony\CompiledUrlMatcher       | benchAll     | 256 (avatax)    | 0.26003 | 984.506183 |
| Symfony\UrlMatcher               | benchLongest | 178 (bitbucket) | 0.19929 | 893.174863 |
| Symfony\UrlMatcher               | benchLongest | 256 (avatax)    | 0.34152 | 749.587818 |
| Symfony\UrlMatcher               | benchLast    | 256 (avatax)    | 0.44005 | 581.754744 |
| Symfony\UrlMatcher               | benchLast    | 178 (bitbucket) | 0.32715 | 544.086402 |
| FastRoute\GroupPosBased          | benchAll     | 256 (avatax)    | 0.77066 | 332.181090 |
| FastRoute\GroupPosBased          | benchSetup   | 256 (avatax)    | 0.77102 | 332.026396 |
| FastRoute\MarkBased              | benchSetup   | 256 (avatax)    | 0.77263 | 331.334507 |
| FastRoute\MarkBased              | benchLast    | 256 (avatax)    | 0.77576 | 329.998489 |
| FastRoute\MarkBased              | benchLongest | 256 (avatax)    | 0.77613 | 329.841261 |
| FastRoute\GroupPosBased          | benchLongest | 256 (avatax)    | 0.77673 | 329.588551 |
| FastRoute\GroupPosBased          | benchLast    | 256 (avatax)    | 0.77784 | 329.115662 |
| FastRoute\GroupCountBased        | benchAll     | 256 (avatax)    | 0.78048 | 328.004521 |
| FastRoute\CharCountBased         | benchSetup   | 256 (avatax)    | 0.78087 | 327.838576 |
| FastRoute\GroupCountBased        | benchSetup   | 256 (avatax)    | 0.78167 | 327.505193 |
| FastRoute\GroupCountBased        | benchLongest | 256 (avatax)    | 0.78193 | 327.395447 |
| FastRoute\MarkBased              | benchAll     | 256 (avatax)    | 0.78236 | 327.214262 |
| FastRoute\GroupCountBased        | benchLast    | 256 (avatax)    | 0.78507 | 326.083912 |
| FastRoute\CharCountBased         | benchLongest | 256 (avatax)    | 0.78596 | 325.715943 |
| FastRoute\CharCountBased         | benchAll     | 256 (avatax)    | 0.78868 | 324.595019 |
| FastRoute\CharCountBased         | benchLast    | 256 (avatax)    | 0.79166 | 323.371115 |
+----------------------------------+--------------+-----------------+---------+------------+
```

## PHP 7.4
```
+----------------------------------+--------------+-----------------+---------+------------+
| Benchmark                        | Case         | Provider Routes | Seconds | Per Second |
+----------------------------------+--------------+-----------------+---------+------------+
| FastRoute\CharCountBased_Cached  | benchSetup   | 256 (avatax)    | 0.00164 | 155727.603 |
| FastRoute\GroupPosBased_Cached   | benchSetup   | 256 (avatax)    | 0.00166 | 154206.782 |
| FastRoute\MarkBased_Cached       | benchSetup   | 256 (avatax)    | 0.00181 | 141748.095 |
| FastRoute\GroupCountBased_Cached | benchSetup   | 256 (avatax)    | 0.00187 | 136677.930 |
| FastRoute\GroupCountBased_Cached | benchSetup   | 178 (bitbucket) | 0.00141 | 126325.907 |
| FastRoute\CharCountBased_Cached  | benchSetup   | 178 (bitbucket) | 0.00148 | 120670.132 |
| FastRoute\MarkBased_Cached       | benchSetup   | 178 (bitbucket) | 0.00164 | 108800.074 |
| FastRoute\GroupPosBased_Cached   | benchSetup   | 178 (bitbucket) | 0.00166 | 107360.671 |
| FastRoute\CharCountBased_Cached  | benchAll     | 256 (avatax)    | 0.00255 | 100349.703 |
| FastRoute\GroupPosBased_Cached   | benchAll     | 256 (avatax)    | 0.00256 | 99845.8084 |
| FastRoute\MarkBased_Cached       | benchAll     | 256 (avatax)    | 0.00280 | 91366.7311 |
| FastRoute\GroupCountBased_Cached | benchAll     | 256 (avatax)    | 0.00288 | 89011.1766 |
| FastRoute\CharCountBased_Cached  | benchAll     | 178 (bitbucket) | 0.00207 | 86081.6455 |
| FastRoute\MarkBased_Cached       | benchAll     | 178 (bitbucket) | 0.00215 | 82861.9436 |
| FastRoute\GroupCountBased_Cached | benchAll     | 178 (bitbucket) | 0.00220 | 81018.5688 |
| FastRoute\CharCountBased_Cached  | benchLongest | 256 (avatax)    | 0.00342 | 74788.7319 |
| FastRoute\MarkBased_Cached       | benchLongest | 256 (avatax)    | 0.00353 | 72481.5596 |
| FastRoute\GroupPosBased_Cached   | benchLongest | 256 (avatax)    | 0.00354 | 72398.4777 |
| FastRoute\GroupPosBased_Cached   | benchAll     | 178 (bitbucket) | 0.00249 | 71628.7164 |
| FastRoute\CharCountBased_Cached  | benchLast    | 256 (avatax)    | 0.00365 | 70156.2772 |
| FastRoute\MarkBased_Cached       | benchLast    | 256 (avatax)    | 0.00373 | 68614.0855 |
| FastRoute\GroupPosBased_Cached   | benchLast    | 256 (avatax)    | 0.00380 | 67331.9009 |
| FastRoute\CharCountBased_Cached  | benchLongest | 178 (bitbucket) | 0.00295 | 60276.6116 |
| FastRoute\GroupCountBased_Cached | benchLongest | 256 (avatax)    | 0.00442 | 57905.5074 |
| FastRoute\MarkBased_Cached       | benchLongest | 178 (bitbucket) | 0.00319 | 55869.6484 |
| FastRoute\GroupCountBased_Cached | benchLast    | 256 (avatax)    | 0.00487 | 52513.4163 |
| FastRoute\GroupPosBased_Cached   | benchLongest | 178 (bitbucket) | 0.00343 | 51864.2662 |
| FastRoute\CharCountBased_Cached  | benchLast    | 178 (bitbucket) | 0.00350 | 50857.3645 |
| FastRoute\MarkBased_Cached       | benchLast    | 178 (bitbucket) | 0.00356 | 50002.4185 |
| FastRoute\GroupCountBased_Cached | benchLongest | 178 (bitbucket) | 0.00361 | 49266.6036 |
| FastRoute\GroupPosBased_Cached   | benchLast    | 178 (bitbucket) | 0.00397 | 44802.3350 |
| FastRoute\GroupCountBased_Cached | benchLast    | 178 (bitbucket) | 0.00400 | 44489.9655 |
| Symfony\UrlMatcher               | benchSetup   | 178 (bitbucket) | 0.03277 | 5431.81089 |
| Symfony\UrlMatcher               | benchAll     | 178 (bitbucket) | 0.03283 | 5422.50032 |
| Symfony\UrlMatcher               | benchSetup   | 256 (avatax)    | 0.06052 | 4229.81128 |
| Symfony\UrlMatcher               | benchAll     | 256 (avatax)    | 0.06342 | 4036.63857 |
| Symfony\CompiledUrlMatcher       | benchSetup   | 178 (bitbucket) | 0.12520 | 1421.70320 |
| Symfony\CompiledUrlMatcher       | benchLast    | 178 (bitbucket) | 0.12576 | 1415.34790 |
| Symfony\CompiledUrlMatcher       | benchLongest | 178 (bitbucket) | 0.12628 | 1409.61051 |
| Symfony\CompiledUrlMatcher       | benchAll     | 178 (bitbucket) | 0.12896 | 1380.27408 |
| FastRoute\GroupPosBased          | benchSetup   | 178 (bitbucket) | 0.13172 | 1351.36290 |
| FastRoute\GroupPosBased          | benchAll     | 178 (bitbucket) | 0.13393 | 1329.09066 |
| FastRoute\GroupPosBased          | benchLongest | 178 (bitbucket) | 0.13583 | 1310.44392 |
| FastRoute\GroupCountBased        | benchAll     | 178 (bitbucket) | 0.13622 | 1306.67106 |
| FastRoute\GroupCountBased        | benchSetup   | 178 (bitbucket) | 0.13640 | 1304.98548 |
| FastRoute\CharCountBased         | benchSetup   | 178 (bitbucket) | 0.13655 | 1303.54318 |
| FastRoute\GroupPosBased          | benchLast    | 178 (bitbucket) | 0.13663 | 1302.75844 |
| FastRoute\GroupCountBased        | benchLast    | 178 (bitbucket) | 0.13833 | 1286.75154 |
| FastRoute\GroupCountBased        | benchLongest | 178 (bitbucket) | 0.13893 | 1281.21120 |
| FastRoute\CharCountBased         | benchAll     | 178 (bitbucket) | 0.13917 | 1279.02067 |
| FastRoute\CharCountBased         | benchLongest | 178 (bitbucket) | 0.14052 | 1266.69694 |
| FastRoute\CharCountBased         | benchLast    | 178 (bitbucket) | 0.14217 | 1252.05834 |
| FastRoute\MarkBased              | benchSetup   | 178 (bitbucket) | 0.14882 | 1196.05150 |
| FastRoute\MarkBased              | benchAll     | 178 (bitbucket) | 0.15118 | 1177.39676 |
| FastRoute\MarkBased              | benchLongest | 178 (bitbucket) | 0.15279 | 1164.98990 |
| FastRoute\MarkBased              | benchLast    | 178 (bitbucket) | 0.15326 | 1161.43231 |
| Symfony\CompiledUrlMatcher       | benchSetup   | 256 (avatax)    | 0.23232 | 1101.95178 |
| Symfony\CompiledUrlMatcher       | benchLast    | 256 (avatax)    | 0.23430 | 1092.61233 |
| Symfony\CompiledUrlMatcher       | benchLongest | 256 (avatax)    | 0.23443 | 1092.01450 |
| Symfony\CompiledUrlMatcher       | benchAll     | 256 (avatax)    | 0.23958 | 1068.51784 |
| Symfony\UrlMatcher               | benchLongest | 178 (bitbucket) | 0.16903 | 1053.08117 |
| Symfony\UrlMatcher               | benchLongest | 256 (avatax)    | 0.28681 | 892.564598 |
| Symfony\UrlMatcher               | benchLast    | 256 (avatax)    | 0.36427 | 702.779147 |
| Symfony\UrlMatcher               | benchLast    | 178 (bitbucket) | 0.27014 | 658.910202 |
| FastRoute\MarkBased              | benchSetup   | 256 (avatax)    | 0.66521 | 384.839217 |
| FastRoute\GroupPosBased          | benchSetup   | 256 (avatax)    | 0.66606 | 384.347986 |
| FastRoute\MarkBased              | benchLast    | 256 (avatax)    | 0.66815 | 383.149167 |
| FastRoute\GroupPosBased          | benchLast    | 256 (avatax)    | 0.66848 | 382.958262 |
| FastRoute\GroupCountBased        | benchAll     | 256 (avatax)    | 0.66892 | 382.708202 |
| FastRoute\MarkBased              | benchAll     | 256 (avatax)    | 0.67010 | 382.033634 |
| FastRoute\GroupPosBased          | benchLongest | 256 (avatax)    | 0.67027 | 381.935657 |
| FastRoute\MarkBased              | benchLongest | 256 (avatax)    | 0.67061 | 381.741481 |
| FastRoute\GroupCountBased        | benchSetup   | 256 (avatax)    | 0.67232 | 380.768828 |
| FastRoute\GroupCountBased        | benchLongest | 256 (avatax)    | 0.67235 | 380.752356 |
| FastRoute\CharCountBased         | benchSetup   | 256 (avatax)    | 0.67372 | 379.982165 |
| FastRoute\CharCountBased         | benchLongest | 256 (avatax)    | 0.67375 | 379.960651 |
| FastRoute\GroupCountBased        | benchLast    | 256 (avatax)    | 0.67441 | 379.593272 |
| FastRoute\CharCountBased         | benchAll     | 256 (avatax)    | 0.67706 | 378.105932 |
| FastRoute\CharCountBased         | benchLast    | 256 (avatax)    | 0.68046 | 376.216102 |
| FastRoute\GroupPosBased          | benchAll     | 256 (avatax)    | 0.79354 | 322.603387 |
+----------------------------------+--------------+-----------------+---------+------------+
```

## PHP 8.0
```
+----------------------------------+--------------+-----------------+---------+------------+
| Benchmark                        | Case         | Provider Routes | Seconds | Per Second |
+----------------------------------+--------------+-----------------+---------+------------+
| FastRoute\GroupCountBased_Cached | benchSetup   | 256 (avatax)    | 0.00227 | 112728.800 |
| FastRoute\GroupPosBased_Cached   | benchSetup   | 256 (avatax)    | 0.00230 | 111072.910 |
| FastRoute\MarkBased_Cached       | benchSetup   | 256 (avatax)    | 0.00255 | 100396.617 |
| FastRoute\CharCountBased_Cached  | benchSetup   | 256 (avatax)    | 0.00261 | 97969.1445 |
| FastRoute\CharCountBased_Cached  | benchSetup   | 178 (bitbucket) | 0.00217 | 82141.7220 |
| FastRoute\MarkBased_Cached       | benchSetup   | 178 (bitbucket) | 0.00239 | 74413.0481 |
| FastRoute\GroupCountBased_Cached | benchSetup   | 178 (bitbucket) | 0.00239 | 74383.3926 |
| FastRoute\GroupPosBased_Cached   | benchSetup   | 178 (bitbucket) | 0.00243 | 73101.5482 |
| FastRoute\GroupPosBased_Cached   | benchAll     | 256 (avatax)    | 0.00389 | 65776.8821 |
| FastRoute\GroupCountBased_Cached | benchAll     | 256 (avatax)    | 0.00396 | 64582.0897 |
| FastRoute\MarkBased_Cached       | benchAll     | 256 (avatax)    | 0.00438 | 58489.0415 |
| FastRoute\CharCountBased_Cached  | benchAll     | 256 (avatax)    | 0.00445 | 57502.3736 |
| FastRoute\GroupPosBased_Cached   | benchLongest | 256 (avatax)    | 0.00482 | 53089.8306 |
| FastRoute\MarkBased_Cached       | benchLongest | 256 (avatax)    | 0.00499 | 51333.4524 |
| FastRoute\GroupPosBased_Cached   | benchLast    | 256 (avatax)    | 0.00501 | 51098.9303 |
| FastRoute\MarkBased_Cached       | benchLast    | 256 (avatax)    | 0.00523 | 48902.0277 |
| FastRoute\GroupCountBased_Cached | benchLongest | 256 (avatax)    | 0.00526 | 48697.9828 |
| FastRoute\GroupCountBased_Cached | benchAll     | 178 (bitbucket) | 0.00372 | 47848.8823 |
| FastRoute\CharCountBased_Cached  | benchLongest | 256 (avatax)    | 0.00536 | 47796.2085 |
| FastRoute\MarkBased_Cached       | benchAll     | 178 (bitbucket) | 0.00373 | 47760.1146 |
| FastRoute\CharCountBased_Cached  | benchAll     | 178 (bitbucket) | 0.00375 | 47441.4508 |
| FastRoute\GroupPosBased_Cached   | benchAll     | 178 (bitbucket) | 0.00382 | 46635.3995 |
| FastRoute\CharCountBased_Cached  | benchLast    | 256 (avatax)    | 0.00555 | 46126.8933 |
| FastRoute\GroupCountBased_Cached | benchLast    | 256 (avatax)    | 0.00559 | 45780.7548 |
| FastRoute\CharCountBased_Cached  | benchLongest | 178 (bitbucket) | 0.00432 | 41222.7989 |
| FastRoute\MarkBased_Cached       | benchLongest | 178 (bitbucket) | 0.00466 | 38196.3630 |
| FastRoute\GroupPosBased_Cached   | benchLongest | 178 (bitbucket) | 0.00487 | 36520.3792 |
| FastRoute\CharCountBased_Cached  | benchLast    | 178 (bitbucket) | 0.00488 | 36466.8642 |
| FastRoute\MarkBased_Cached       | benchLast    | 178 (bitbucket) | 0.00505 | 35241.2608 |
| FastRoute\GroupCountBased_Cached | benchLongest | 178 (bitbucket) | 0.00506 | 35150.0052 |
| FastRoute\GroupPosBased_Cached   | benchLast    | 178 (bitbucket) | 0.00544 | 32733.5194 |
| FastRoute\GroupCountBased_Cached | benchLast    | 178 (bitbucket) | 0.00600 | 29691.2353 |
| Symfony\UrlMatcher               | benchSetup   | 178 (bitbucket) | 0.03478 | 5117.28374 |
| Symfony\UrlMatcher               | benchAll     | 178 (bitbucket) | 0.03504 | 5079.33538 |
| Symfony\UrlMatcher               | benchSetup   | 256 (avatax)    | 0.05716 | 4478.98178 |
| Symfony\UrlMatcher               | benchAll     | 256 (avatax)    | 0.07018 | 3647.60495 |
| FastRoute\GroupPosBased          | benchSetup   | 178 (bitbucket) | 0.12430 | 1432.05498 |
| FastRoute\MarkBased              | benchSetup   | 178 (bitbucket) | 0.12656 | 1406.48228 |
| FastRoute\GroupPosBased          | benchAll     | 178 (bitbucket) | 0.12662 | 1405.81488 |
| FastRoute\GroupCountBased        | benchSetup   | 178 (bitbucket) | 0.12691 | 1402.55589 |
| FastRoute\MarkBased              | benchAll     | 178 (bitbucket) | 0.12771 | 1393.77384 |
| FastRoute\MarkBased              | benchLongest | 178 (bitbucket) | 0.13025 | 1366.57040 |
| FastRoute\GroupPosBased          | benchLast    | 178 (bitbucket) | 0.13063 | 1362.62709 |
| FastRoute\GroupCountBased        | benchAll     | 178 (bitbucket) | 0.13082 | 1360.65776 |
| FastRoute\GroupCountBased        | benchLongest | 178 (bitbucket) | 0.13205 | 1347.97387 |
| FastRoute\GroupCountBased        | benchLast    | 178 (bitbucket) | 0.13232 | 1345.18323 |
| FastRoute\MarkBased              | benchLast    | 178 (bitbucket) | 0.13467 | 1321.76799 |
| FastRoute\GroupPosBased          | benchLongest | 178 (bitbucket) | 0.13652 | 1303.80042 |
| Symfony\CompiledUrlMatcher       | benchSetup   | 178 (bitbucket) | 0.14237 | 1250.28865 |
| Symfony\CompiledUrlMatcher       | benchAll     | 178 (bitbucket) | 0.14414 | 1234.91863 |
| FastRoute\CharCountBased         | benchSetup   | 178 (bitbucket) | 0.14428 | 1233.73706 |
| Symfony\CompiledUrlMatcher       | benchLast    | 178 (bitbucket) | 0.14524 | 1225.56717 |
| Symfony\CompiledUrlMatcher       | benchLongest | 178 (bitbucket) | 0.14701 | 1210.83464 |
| FastRoute\CharCountBased         | benchAll     | 178 (bitbucket) | 0.14847 | 1198.90370 |
| FastRoute\CharCountBased         | benchLast    | 178 (bitbucket) | 0.15241 | 1167.90944 |
| FastRoute\CharCountBased         | benchLongest | 178 (bitbucket) | 0.15534 | 1145.89499 |
| Symfony\CompiledUrlMatcher       | benchSetup   | 256 (avatax)    | 0.23186 | 1104.11038 |
| Symfony\UrlMatcher               | benchLongest | 178 (bitbucket) | 0.17283 | 1029.91316 |
| Symfony\UrlMatcher               | benchLongest | 256 (avatax)    | 0.26246 | 975.379661 |
| Symfony\CompiledUrlMatcher       | benchLast    | 256 (avatax)    | 0.26425 | 968.794277 |
| Symfony\CompiledUrlMatcher       | benchLongest | 256 (avatax)    | 0.26466 | 967.275720 |
| Symfony\CompiledUrlMatcher       | benchAll     | 256 (avatax)    | 0.26696 | 958.937791 |
| Symfony\UrlMatcher               | benchLast    | 256 (avatax)    | 0.34673 | 738.333265 |
| Symfony\UrlMatcher               | benchLast    | 178 (bitbucket) | 0.26853 | 662.875537 |
| FastRoute\GroupPosBased          | benchSetup   | 256 (avatax)    | 0.61819 | 414.114847 |
| FastRoute\GroupPosBased          | benchAll     | 256 (avatax)    | 0.61950 | 413.235738 |
| FastRoute\GroupCountBased        | benchSetup   | 256 (avatax)    | 0.61962 | 413.159096 |
| FastRoute\GroupPosBased          | benchLast    | 256 (avatax)    | 0.62449 | 409.934491 |
| FastRoute\MarkBased              | benchAll     | 256 (avatax)    | 0.62474 | 409.767881 |
| FastRoute\MarkBased              | benchLongest | 256 (avatax)    | 0.62725 | 408.128120 |
| FastRoute\GroupCountBased        | benchLast    | 256 (avatax)    | 0.63560 | 402.766411 |
| FastRoute\CharCountBased         | benchLongest | 256 (avatax)    | 0.63638 | 402.273437 |
| FastRoute\GroupPosBased          | benchLongest | 256 (avatax)    | 0.63954 | 400.284599 |
| FastRoute\MarkBased              | benchSetup   | 256 (avatax)    | 0.70022 | 365.600944 |
| FastRoute\GroupCountBased        | benchAll     | 256 (avatax)    | 0.70334 | 363.978058 |
| FastRoute\CharCountBased         | benchSetup   | 256 (avatax)    | 0.70634 | 362.430673 |
| FastRoute\MarkBased              | benchLast    | 256 (avatax)    | 0.70724 | 361.971033 |
| FastRoute\GroupCountBased        | benchLongest | 256 (avatax)    | 0.70990 | 360.614705 |
| FastRoute\CharCountBased         | benchLast    | 256 (avatax)    | 0.71544 | 357.822696 |
| FastRoute\CharCountBased         | benchAll     | 256 (avatax)    | 0.72136 | 354.886639 |
+----------------------------------+--------------+-----------------+---------+------------+
```
