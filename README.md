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
+----------------------------------+--------------+-----------------+---------+------------+
| Benchmark                        | Case         | Provider Routes | Seconds | Per Second |
+----------------------------------+--------------+-----------------+---------+------------+
| FastRoute\MarkBased_Cached       | benchSetup   | 256 (avatax)    | 0.09022 | 2837.41163 |
| FastRoute\GroupPosBased_Cached   | benchSetup   | 256 (avatax)    | 0.09217 | 2777.47640 |
| FastRoute\GroupCountBased_Cached | benchSetup   | 256 (avatax)    | 0.09331 | 2743.66575 |
| FastRoute\MarkBased_Cached       | benchSetup   | 178 (bitbucket) | 0.06641 | 2680.40322 |
| FastRoute\MarkBased_Cached       | benchAll     | 256 (avatax)    | 0.09608 | 2664.53045 |
| FastRoute\MarkBased_Cached       | benchLongest | 256 (avatax)    | 0.09640 | 2655.71269 |
| FastRoute\CharCountBased_Cached  | benchSetup   | 256 (avatax)    | 0.09694 | 2640.72970 |
| FastRoute\MarkBased_Cached       | benchLast    | 256 (avatax)    | 0.09723 | 2632.82361 |
| FastRoute\GroupPosBased_Cached   | benchAll     | 256 (avatax)    | 0.09838 | 2602.20931 |
| FastRoute\GroupCountBased_Cached | benchSetup   | 178 (bitbucket) | 0.06882 | 2586.57392 |
| FastRoute\GroupCountBased_Cached | benchAll     | 256 (avatax)    | 0.09971 | 2567.47046 |
| FastRoute\MarkBased_Cached       | benchAll     | 178 (bitbucket) | 0.06934 | 2566.91116 |
| FastRoute\GroupPosBased_Cached   | benchSetup   | 178 (bitbucket) | 0.06954 | 2559.67700 |
| FastRoute\GroupPosBased_Cached   | benchLongest | 256 (avatax)    | 0.10074 | 2541.24438 |
| FastRoute\GroupPosBased_Cached   | benchLast    | 256 (avatax)    | 0.10110 | 2532.17107 |
| FastRoute\GroupCountBased_Cached | benchLongest | 256 (avatax)    | 0.10143 | 2523.83843 |
| FastRoute\MarkBased_Cached       | benchLongest | 178 (bitbucket) | 0.07067 | 2518.74455 |
| FastRoute\CharCountBased_Cached  | benchSetup   | 178 (bitbucket) | 0.07119 | 2500.20465 |
| FastRoute\GroupCountBased_Cached | benchLast    | 256 (avatax)    | 0.10255 | 2496.31930 |
| FastRoute\CharCountBased_Cached  | benchAll     | 256 (avatax)    | 0.10280 | 2490.34428 |
| FastRoute\GroupPosBased_Cached   | benchAll     | 178 (bitbucket) | 0.07195 | 2473.83508 |
| FastRoute\GroupCountBased_Cached | benchAll     | 178 (bitbucket) | 0.07204 | 2470.78133 |
| FastRoute\MarkBased_Cached       | benchLast    | 178 (bitbucket) | 0.07228 | 2462.57454 |
| FastRoute\CharCountBased_Cached  | benchLongest | 256 (avatax)    | 0.10449 | 2449.88243 |
| FastRoute\CharCountBased_Cached  | benchLast    | 256 (avatax)    | 0.10496 | 2438.93102 |
| FastRoute\GroupCountBased_Cached | benchLongest | 178 (bitbucket) | 0.07450 | 2389.35845 |
| FastRoute\CharCountBased_Cached  | benchAll     | 178 (bitbucket) | 0.07465 | 2384.55825 |
| FastRoute\GroupPosBased_Cached   | benchLongest | 178 (bitbucket) | 0.07492 | 2375.80148 |
| FastRoute\GroupPosBased_Cached   | benchLast    | 178 (bitbucket) | 0.07548 | 2358.30812 |
| FastRoute\CharCountBased_Cached  | benchLongest | 178 (bitbucket) | 0.07587 | 2346.08772 |
| FastRoute\GroupCountBased_Cached | benchLast    | 178 (bitbucket) | 0.07688 | 2315.44083 |
| FastRoute\CharCountBased_Cached  | benchLast    | 178 (bitbucket) | 0.07770 | 2290.89336 |
| Symfony\CompiledUrlMatcher       | benchSetup   | 178 (bitbucket) | 0.13785 | 1291.26934 |
| Symfony\CompiledUrlMatcher       | benchLast    | 178 (bitbucket) | 0.14079 | 1264.31159 |
| Symfony\CompiledUrlMatcher       | benchLongest | 178 (bitbucket) | 0.14164 | 1256.66318 |
| Symfony\CompiledUrlMatcher       | benchAll     | 178 (bitbucket) | 0.14225 | 1251.33434 |
| Symfony\CompiledUrlMatcher       | benchSetup   | 256 (avatax)    | 0.25678 | 996.962733 |
| Symfony\CompiledUrlMatcher       | benchLongest | 256 (avatax)    | 0.26201 | 977.076695 |
| Symfony\CompiledUrlMatcher       | benchLast    | 256 (avatax)    | 0.26260 | 974.881968 |
| Symfony\CompiledUrlMatcher       | benchAll     | 256 (avatax)    | 0.26561 | 963.833915 |
| Symfony\UrlMatcher               | benchSetup   | 178 (bitbucket) | 0.36291 | 490.486456 |
| Symfony\UrlMatcher               | benchAll     | 178 (bitbucket) | 0.37694 | 472.223681 |
| Symfony\UrlMatcher               | benchSetup   | 256 (avatax)    | 0.73931 | 346.268805 |
| Symfony\UrlMatcher               | benchAll     | 256 (avatax)    | 0.76388 | 335.129806 |
| FastRoute\GroupPosBased          | benchAll     | 178 (bitbucket) | 0.83636 | 212.827563 |
| FastRoute\MarkBased              | benchLongest | 178 (bitbucket) | 0.83774 | 212.476680 |
| FastRoute\MarkBased              | benchAll     | 178 (bitbucket) | 0.84239 | 211.304793 |
| FastRoute\MarkBased              | benchSetup   | 178 (bitbucket) | 0.84354 | 211.015434 |
| FastRoute\GroupPosBased          | benchSetup   | 178 (bitbucket) | 0.84413 | 210.868044 |
| FastRoute\GroupPosBased          | benchLongest | 178 (bitbucket) | 0.84486 | 210.686012 |
| FastRoute\CharCountBased         | benchLongest | 178 (bitbucket) | 0.84552 | 210.521806 |
| FastRoute\MarkBased              | benchLast    | 178 (bitbucket) | 0.84862 | 209.752083 |
| FastRoute\CharCountBased         | benchSetup   | 178 (bitbucket) | 0.85137 | 209.073824 |
| FastRoute\CharCountBased         | benchLast    | 178 (bitbucket) | 0.85358 | 208.532714 |
| FastRoute\CharCountBased         | benchAll     | 178 (bitbucket) | 0.85524 | 208.128222 |
| FastRoute\GroupCountBased        | benchSetup   | 178 (bitbucket) | 0.86156 | 206.601723 |
| FastRoute\GroupPosBased          | benchLast    | 178 (bitbucket) | 0.86238 | 206.406492 |
| FastRoute\GroupCountBased        | benchAll     | 178 (bitbucket) | 0.86901 | 204.830285 |
| FastRoute\GroupCountBased        | benchLast    | 178 (bitbucket) | 0.87022 | 204.546662 |
| FastRoute\GroupCountBased        | benchLongest | 178 (bitbucket) | 0.88361 | 201.445902 |
| Symfony\UrlMatcher               | benchLongest | 178 (bitbucket) | 1.18227 | 150.557697 |
| Symfony\UrlMatcher               | benchLongest | 256 (avatax)    | 2.22922 | 114.838366 |
| Symfony\UrlMatcher               | benchLast    | 178 (bitbucket) | 1.91441 | 92.9791365 |
| Symfony\UrlMatcher               | benchLast    | 256 (avatax)    | 2.79772 | 91.5031137 |
| FastRoute\MarkBased              | benchLongest | 256 (avatax)    | 3.63333 | 70.4587781 |
| FastRoute\MarkBased              | benchAll     | 256 (avatax)    | 3.68797 | 69.4149187 |
| FastRoute\GroupPosBased          | benchAll     | 256 (avatax)    | 3.69528 | 69.2775500 |
| FastRoute\GroupPosBased          | benchLast    | 256 (avatax)    | 3.70208 | 69.1503687 |
| FastRoute\CharCountBased         | benchAll     | 256 (avatax)    | 3.70265 | 69.1396689 |
| FastRoute\GroupCountBased        | benchSetup   | 256 (avatax)    | 3.70421 | 69.1105695 |
| FastRoute\MarkBased              | benchLast    | 256 (avatax)    | 3.70477 | 69.1001978 |
| FastRoute\CharCountBased         | benchLast    | 256 (avatax)    | 3.71068 | 68.9901432 |
| FastRoute\MarkBased              | benchSetup   | 256 (avatax)    | 3.72878 | 68.6550881 |
| FastRoute\GroupCountBased        | benchLast    | 256 (avatax)    | 3.73814 | 68.4832544 |
| FastRoute\CharCountBased         | benchSetup   | 256 (avatax)    | 3.75276 | 68.2164562 |
| FastRoute\CharCountBased         | benchLongest | 256 (avatax)    | 3.75321 | 68.2082791 |
| FastRoute\GroupCountBased        | benchLongest | 256 (avatax)    | 3.75530 | 68.1702665 |
| FastRoute\GroupPosBased          | benchSetup   | 256 (avatax)    | 3.76291 | 68.0325418 |
| FastRoute\GroupPosBased          | benchLongest | 256 (avatax)    | 3.76440 | 68.0055813 |
| FastRoute\GroupCountBased        | benchAll     | 256 (avatax)    | 3.80114 | 67.3481646 |
+----------------------------------+--------------+-----------------+---------+------------+
```

## PHP 7.4
```
+----------------------------------+--------------+-----------------+---------+------------+
| Benchmark                        | Case         | Provider Routes | Seconds | Per Second |
+----------------------------------+--------------+-----------------+---------+------------+
| FastRoute\MarkBased_Cached       | benchSetup   | 256 (avatax)    | 0.07969 | 3212.44906 |
| FastRoute\GroupPosBased_Cached   | benchSetup   | 256 (avatax)    | 0.08291 | 3087.79860 |
| FastRoute\GroupCountBased_Cached | benchSetup   | 256 (avatax)    | 0.08337 | 3070.53585 |
| FastRoute\MarkBased_Cached       | benchAll     | 256 (avatax)    | 0.08470 | 3022.47081 |
| FastRoute\MarkBased_Cached       | benchLongest | 256 (avatax)    | 0.08479 | 3019.19031 |
| FastRoute\MarkBased_Cached       | benchLast    | 256 (avatax)    | 0.08558 | 2991.45759 |
| FastRoute\MarkBased_Cached       | benchSetup   | 178 (bitbucket) | 0.06017 | 2958.48733 |
| FastRoute\CharCountBased_Cached  | benchSetup   | 256 (avatax)    | 0.08658 | 2956.94008 |
| FastRoute\GroupPosBased_Cached   | benchAll     | 256 (avatax)    | 0.08763 | 2921.34104 |
| FastRoute\GroupCountBased_Cached | benchAll     | 256 (avatax)    | 0.08835 | 2897.59588 |
| FastRoute\GroupPosBased_Cached   | benchSetup   | 178 (bitbucket) | 0.06221 | 2861.31636 |
| FastRoute\GroupPosBased_Cached   | benchLongest | 256 (avatax)    | 0.08957 | 2858.16683 |
| FastRoute\MarkBased_Cached       | benchAll     | 178 (bitbucket) | 0.06263 | 2842.17782 |
| FastRoute\GroupPosBased_Cached   | benchLast    | 256 (avatax)    | 0.09013 | 2840.21865 |
| FastRoute\GroupCountBased_Cached | benchLongest | 256 (avatax)    | 0.09030 | 2835.02179 |
| FastRoute\GroupCountBased_Cached | benchSetup   | 178 (bitbucket) | 0.06295 | 2827.59211 |
| FastRoute\GroupCountBased_Cached | benchLast    | 256 (avatax)    | 0.09106 | 2811.29875 |
| FastRoute\CharCountBased_Cached  | benchAll     | 256 (avatax)    | 0.09108 | 2810.86454 |
| FastRoute\MarkBased_Cached       | benchLongest | 178 (bitbucket) | 0.06362 | 2798.03658 |
| FastRoute\CharCountBased_Cached  | benchLongest | 256 (avatax)    | 0.09155 | 2796.37744 |
| FastRoute\CharCountBased_Cached  | benchSetup   | 178 (bitbucket) | 0.06366 | 2796.31787 |
| FastRoute\CharCountBased_Cached  | benchLast    | 256 (avatax)    | 0.09200 | 2782.75990 |
| FastRoute\MarkBased_Cached       | benchLast    | 178 (bitbucket) | 0.06460 | 2755.59123 |
| FastRoute\GroupPosBased_Cached   | benchAll     | 178 (bitbucket) | 0.06511 | 2733.87642 |
| FastRoute\GroupCountBased_Cached | benchAll     | 178 (bitbucket) | 0.06541 | 2721.09236 |
| FastRoute\GroupPosBased_Cached   | benchLongest | 178 (bitbucket) | 0.06686 | 2662.39488 |
| FastRoute\GroupCountBased_Cached | benchLongest | 178 (bitbucket) | 0.06732 | 2644.16796 |
| FastRoute\GroupPosBased_Cached   | benchLast    | 178 (bitbucket) | 0.06790 | 2621.42159 |
| FastRoute\CharCountBased_Cached  | benchLongest | 178 (bitbucket) | 0.06850 | 2598.69231 |
| FastRoute\CharCountBased_Cached  | benchLast    | 178 (bitbucket) | 0.06899 | 2580.04869 |
| FastRoute\GroupCountBased_Cached | benchLast    | 178 (bitbucket) | 0.06930 | 2568.68632 |
| FastRoute\CharCountBased_Cached  | benchAll     | 178 (bitbucket) | 0.08578 | 2075.00309 |
| Symfony\CompiledUrlMatcher       | benchLast    | 178 (bitbucket) | 0.13060 | 1362.88828 |
| Symfony\CompiledUrlMatcher       | benchAll     | 178 (bitbucket) | 0.13231 | 1345.34806 |
| Symfony\CompiledUrlMatcher       | benchLongest | 178 (bitbucket) | 0.14129 | 1259.77603 |
| Symfony\CompiledUrlMatcher       | benchSetup   | 178 (bitbucket) | 0.14788 | 1203.71878 |
| Symfony\CompiledUrlMatcher       | benchSetup   | 256 (avatax)    | 0.23939 | 1069.38514 |
| Symfony\CompiledUrlMatcher       | benchLongest | 256 (avatax)    | 0.24244 | 1055.93142 |
| Symfony\CompiledUrlMatcher       | benchAll     | 256 (avatax)    | 0.24724 | 1035.41889 |
| Symfony\CompiledUrlMatcher       | benchLast    | 256 (avatax)    | 0.25250 | 1013.84871 |
| Symfony\UrlMatcher               | benchSetup   | 178 (bitbucket) | 0.31884 | 558.282462 |
| Symfony\UrlMatcher               | benchAll     | 178 (bitbucket) | 0.32702 | 544.307349 |
| Symfony\UrlMatcher               | benchSetup   | 256 (avatax)    | 0.66418 | 385.435307 |
| Symfony\UrlMatcher               | benchAll     | 256 (avatax)    | 0.67256 | 380.635737 |
| FastRoute\MarkBased              | benchSetup   | 178 (bitbucket) | 0.77005 | 231.155309 |
| FastRoute\GroupPosBased          | benchAll     | 178 (bitbucket) | 0.77327 | 230.190730 |
| FastRoute\MarkBased              | benchAll     | 178 (bitbucket) | 0.78423 | 226.975128 |
| FastRoute\MarkBased              | benchLast    | 178 (bitbucket) | 0.78530 | 226.664344 |
| FastRoute\MarkBased              | benchLongest | 178 (bitbucket) | 0.78542 | 226.629460 |
| FastRoute\CharCountBased         | benchSetup   | 178 (bitbucket) | 0.78958 | 225.435732 |
| FastRoute\GroupPosBased          | benchLast    | 178 (bitbucket) | 0.78964 | 225.418307 |
| FastRoute\GroupPosBased          | benchLongest | 178 (bitbucket) | 0.79160 | 224.860434 |
| FastRoute\GroupPosBased          | benchSetup   | 178 (bitbucket) | 0.79228 | 224.668666 |
| FastRoute\CharCountBased         | benchLongest | 178 (bitbucket) | 0.79400 | 224.181385 |
| FastRoute\GroupCountBased        | benchSetup   | 178 (bitbucket) | 0.80016 | 222.455793 |
| FastRoute\CharCountBased         | benchLast    | 178 (bitbucket) | 0.80053 | 222.353498 |
| FastRoute\GroupCountBased        | benchLongest | 178 (bitbucket) | 0.80191 | 221.969209 |
| FastRoute\GroupCountBased        | benchLast    | 178 (bitbucket) | 0.80216 | 221.899739 |
| FastRoute\CharCountBased         | benchAll     | 178 (bitbucket) | 0.80769 | 220.381282 |
| FastRoute\GroupCountBased        | benchAll     | 178 (bitbucket) | 0.82000 | 217.072115 |
| Symfony\UrlMatcher               | benchLongest | 178 (bitbucket) | 1.11833 | 159.165729 |
| Symfony\UrlMatcher               | benchLongest | 256 (avatax)    | 2.09253 | 122.339997 |
| Symfony\UrlMatcher               | benchLast    | 178 (bitbucket) | 1.79200 | 99.3301426 |
| Symfony\UrlMatcher               | benchLast    | 256 (avatax)    | 2.61336 | 97.9582582 |
| FastRoute\GroupPosBased          | benchAll     | 256 (avatax)    | 3.45106 | 74.1800852 |
| FastRoute\MarkBased              | benchLongest | 256 (avatax)    | 3.45278 | 74.1431335 |
| FastRoute\GroupPosBased          | benchLongest | 256 (avatax)    | 3.45568 | 74.0809357 |
| FastRoute\MarkBased              | benchSetup   | 256 (avatax)    | 3.45643 | 74.0649005 |
| FastRoute\MarkBased              | benchLast    | 256 (avatax)    | 3.45842 | 74.0223017 |
| FastRoute\CharCountBased         | benchAll     | 256 (avatax)    | 3.46305 | 73.9232781 |
| FastRoute\GroupCountBased        | benchLongest | 256 (avatax)    | 3.46957 | 73.7842952 |
| FastRoute\MarkBased              | benchAll     | 256 (avatax)    | 3.47391 | 73.6920968 |
| FastRoute\GroupCountBased        | benchLast    | 256 (avatax)    | 3.47467 | 73.6761031 |
| FastRoute\CharCountBased         | benchSetup   | 256 (avatax)    | 3.47878 | 73.5891220 |
| FastRoute\GroupCountBased        | benchSetup   | 256 (avatax)    | 3.47977 | 73.5680616 |
| FastRoute\GroupPosBased          | benchSetup   | 256 (avatax)    | 3.48565 | 73.4439811 |
| FastRoute\CharCountBased         | benchLast    | 256 (avatax)    | 3.49154 | 73.3200381 |
| FastRoute\GroupPosBased          | benchLast    | 256 (avatax)    | 3.50653 | 73.0066267 |
| FastRoute\CharCountBased         | benchLongest | 256 (avatax)    | 3.50750 | 72.9865185 |
| FastRoute\GroupCountBased        | benchAll     | 256 (avatax)    | 3.51079 | 72.9180638 |
+----------------------------------+--------------+-----------------+---------+------------+
```

## PHP 8.0
```
+----------------------------------+--------------+-----------------+---------+------------+
| Benchmark                        | Case         | Provider Routes | Seconds | Per Second |
+----------------------------------+--------------+-----------------+---------+------------+
| FastRoute\MarkBased_Cached       | benchSetup   | 256 (avatax)    | 0.08374 | 3056.96844 |
| FastRoute\MarkBased_Cached       | benchAll     | 256 (avatax)    | 0.08788 | 2913.02719 |
| FastRoute\MarkBased_Cached       | benchLongest | 256 (avatax)    | 0.08869 | 2886.52690 |
| FastRoute\MarkBased_Cached       | benchLast    | 256 (avatax)    | 0.08962 | 2856.57002 |
| FastRoute\GroupPosBased_Cached   | benchSetup   | 256 (avatax)    | 0.09857 | 2597.06085 |
| FastRoute\GroupCountBased_Cached | benchSetup   | 256 (avatax)    | 0.09959 | 2570.54373 |
| FastRoute\MarkBased_Cached       | benchSetup   | 178 (bitbucket) | 0.07043 | 2527.22799 |
| FastRoute\CharCountBased_Cached  | benchSetup   | 256 (avatax)    | 0.10234 | 2501.46611 |
| FastRoute\GroupPosBased_Cached   | benchAll     | 256 (avatax)    | 0.10265 | 2493.88994 |
| FastRoute\GroupCountBased_Cached | benchAll     | 256 (avatax)    | 0.10342 | 2475.46264 |
| FastRoute\GroupPosBased_Cached   | benchSetup   | 178 (bitbucket) | 0.07261 | 2451.52069 |
| FastRoute\GroupPosBased_Cached   | benchLongest | 256 (avatax)    | 0.10457 | 2448.00572 |
| FastRoute\MarkBased_Cached       | benchAll     | 178 (bitbucket) | 0.07294 | 2440.23060 |
| FastRoute\GroupPosBased_Cached   | benchLast    | 256 (avatax)    | 0.10495 | 2439.16372 |
| FastRoute\GroupCountBased_Cached | benchSetup   | 178 (bitbucket) | 0.07307 | 2436.01861 |
| FastRoute\GroupCountBased_Cached | benchLongest | 256 (avatax)    | 0.10562 | 2423.69249 |
| FastRoute\MarkBased_Cached       | benchLongest | 178 (bitbucket) | 0.07406 | 2403.32632 |
| FastRoute\GroupCountBased_Cached | benchLast    | 256 (avatax)    | 0.10663 | 2400.78038 |
| FastRoute\CharCountBased_Cached  | benchAll     | 256 (avatax)    | 0.10761 | 2378.96134 |
| FastRoute\CharCountBased_Cached  | benchLongest | 256 (avatax)    | 0.10777 | 2375.31954 |
| FastRoute\CharCountBased_Cached  | benchLast    | 256 (avatax)    | 0.10842 | 2361.29410 |
| FastRoute\GroupPosBased_Cached   | benchAll     | 178 (bitbucket) | 0.07539 | 2361.17963 |
| FastRoute\GroupCountBased_Cached | benchAll     | 178 (bitbucket) | 0.07591 | 2345.00448 |
| FastRoute\CharCountBased_Cached  | benchSetup   | 178 (bitbucket) | 0.07671 | 2320.36310 |
| FastRoute\MarkBased_Cached       | benchLast    | 178 (bitbucket) | 0.07681 | 2317.43169 |
| FastRoute\GroupPosBased_Cached   | benchLongest | 178 (bitbucket) | 0.07755 | 2295.38704 |
| FastRoute\GroupCountBased_Cached | benchLongest | 178 (bitbucket) | 0.07794 | 2283.66173 |
| FastRoute\CharCountBased_Cached  | benchAll     | 178 (bitbucket) | 0.07832 | 2272.84412 |
| FastRoute\GroupCountBased_Cached | benchLast    | 178 (bitbucket) | 0.07965 | 2234.66553 |
| FastRoute\CharCountBased_Cached  | benchLongest | 178 (bitbucket) | 0.07992 | 2227.36527 |
| FastRoute\GroupPosBased_Cached   | benchLast    | 178 (bitbucket) | 0.08018 | 2220.11255 |
| FastRoute\CharCountBased_Cached  | benchLast    | 178 (bitbucket) | 0.08081 | 2202.80626 |
| Symfony\CompiledUrlMatcher       | benchSetup   | 178 (bitbucket) | 0.12466 | 1427.90551 |
| Symfony\CompiledUrlMatcher       | benchLast    | 178 (bitbucket) | 0.12714 | 1400.04409 |
| Symfony\CompiledUrlMatcher       | benchLongest | 178 (bitbucket) | 0.12825 | 1387.95677 |
| Symfony\CompiledUrlMatcher       | benchAll     | 178 (bitbucket) | 0.12863 | 1383.85847 |
| Symfony\CompiledUrlMatcher       | benchLast    | 256 (avatax)    | 0.23392 | 1094.37740 |
| Symfony\CompiledUrlMatcher       | benchLongest | 256 (avatax)    | 0.23474 | 1090.56377 |
| Symfony\CompiledUrlMatcher       | benchAll     | 256 (avatax)    | 0.23736 | 1078.54891 |
| Symfony\CompiledUrlMatcher       | benchSetup   | 256 (avatax)    | 0.26040 | 983.087402 |
| Symfony\UrlMatcher               | benchSetup   | 178 (bitbucket) | 0.33309 | 534.394970 |
| Symfony\UrlMatcher               | benchAll     | 178 (bitbucket) | 0.34428 | 517.016726 |
| Symfony\UrlMatcher               | benchSetup   | 256 (avatax)    | 0.59543 | 429.938362 |
| Symfony\UrlMatcher               | benchAll     | 256 (avatax)    | 0.69191 | 369.992978 |
| FastRoute\CharCountBased         | benchSetup   | 178 (bitbucket) | 0.68894 | 258.366836 |
| FastRoute\CharCountBased         | benchLongest | 178 (bitbucket) | 0.69524 | 256.025985 |
| FastRoute\CharCountBased         | benchAll     | 178 (bitbucket) | 0.69652 | 255.557647 |
| FastRoute\CharCountBased         | benchLast    | 178 (bitbucket) | 0.70001 | 254.281366 |
| FastRoute\GroupPosBased          | benchAll     | 178 (bitbucket) | 0.78069 | 228.004351 |
| FastRoute\GroupPosBased          | benchLongest | 178 (bitbucket) | 0.78112 | 227.877066 |
| FastRoute\MarkBased              | benchSetup   | 178 (bitbucket) | 0.78163 | 227.728387 |
| FastRoute\GroupPosBased          | benchLast    | 178 (bitbucket) | 0.78300 | 227.331058 |
| FastRoute\MarkBased              | benchAll     | 178 (bitbucket) | 0.78382 | 227.091805 |
| FastRoute\MarkBased              | benchLast    | 178 (bitbucket) | 0.79119 | 224.978676 |
| FastRoute\GroupCountBased        | benchSetup   | 178 (bitbucket) | 0.79127 | 224.954814 |
| FastRoute\MarkBased              | benchLongest | 178 (bitbucket) | 0.79293 | 224.483030 |
| FastRoute\GroupPosBased          | benchSetup   | 178 (bitbucket) | 0.79404 | 224.170009 |
| FastRoute\GroupCountBased        | benchAll     | 178 (bitbucket) | 0.79435 | 224.082070 |
| FastRoute\GroupCountBased        | benchLongest | 178 (bitbucket) | 0.79529 | 223.817124 |
| FastRoute\GroupCountBased        | benchLast    | 178 (bitbucket) | 0.81528 | 218.330420 |
| Symfony\UrlMatcher               | benchLongest | 178 (bitbucket) | 1.02169 | 174.221649 |
| Symfony\UrlMatcher               | benchLongest | 256 (avatax)    | 1.90342 | 134.494669 |
| Symfony\UrlMatcher               | benchLast    | 178 (bitbucket) | 1.57079 | 113.318926 |
| Symfony\UrlMatcher               | benchLast    | 256 (avatax)    | 2.38757 | 107.221980 |
| FastRoute\MarkBased              | benchSetup   | 256 (avatax)    | 3.37244 | 75.9094980 |
| FastRoute\MarkBased              | benchAll     | 256 (avatax)    | 3.37572 | 75.8357640 |
| FastRoute\CharCountBased         | benchSetup   | 256 (avatax)    | 3.37657 | 75.8166476 |
| FastRoute\CharCountBased         | benchLast    | 256 (avatax)    | 3.38586 | 75.6085131 |
| FastRoute\CharCountBased         | benchAll     | 256 (avatax)    | 3.39832 | 75.3312300 |
| FastRoute\GroupCountBased        | benchLongest | 256 (avatax)    | 3.40114 | 75.2688176 |
| FastRoute\GroupCountBased        | benchLast    | 256 (avatax)    | 3.40501 | 75.1834384 |
| FastRoute\GroupPosBased          | benchLast    | 256 (avatax)    | 3.42492 | 74.7463789 |
| FastRoute\GroupPosBased          | benchSetup   | 256 (avatax)    | 3.43131 | 74.6071585 |
| FastRoute\MarkBased              | benchLongest | 256 (avatax)    | 3.43555 | 74.5150808 |
| FastRoute\GroupCountBased        | benchAll     | 256 (avatax)    | 3.45952 | 73.9986161 |
| FastRoute\MarkBased              | benchLast    | 256 (avatax)    | 3.46603 | 73.8597616 |
| FastRoute\CharCountBased         | benchLongest | 256 (avatax)    | 3.50615 | 73.0146245 |
| FastRoute\GroupPosBased          | benchAll     | 256 (avatax)    | 3.56574 | 71.7944526 |
| FastRoute\GroupCountBased        | benchSetup   | 256 (avatax)    | 3.57845 | 71.5393352 |
| FastRoute\GroupPosBased          | benchLongest | 256 (avatax)    | 3.59386 | 71.2326607 |
+----------------------------------+--------------+-----------------+---------+------------+
```
