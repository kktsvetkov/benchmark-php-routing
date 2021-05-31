# Benchmark PHP Routing

Take a real world routing scenario in the form of [Bitbucket API](https://developer.atlassian.com/bitbucket/api/2/reference/resource/) and benchmark PHP routing packages against it.

You can read more about this here: http://kaloyan.info/writing/2021/05/31/benchmark-php-routing.html

# Packages
Here are the packages that are benchmakred:

* Symfony Routing [symfony/routing](https://github.com/symfony/routing)
* Fast Route [nikic/fast-route](https://github.com/nikic/fast-route)

So far these are the most popular ones: **Symfony Routing** component is used not only by
them but by **Laravel** as well, and FastRoute is used by other popular solutions such
as the [Slim](https://github.com/slimphp/Slim) framework and [League\Route](https://github.com/thephpleague/route).

# Benchmarks

This is the list of the available [phpbench](https://github.com/phpbench/phpbench)
benchmarks. They are combination of the packages and the strategies they provide.

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
+------------------+--------------+--------+------------------+-----------------+
| Case             | Scenario     | Routes | Time             | Per Second      |
+------------------+--------------+--------+------------------+-----------------+
| symfony_compiled | benchAll     | 364    | 0.344928 seconds | 1055.2926186103 |
| symfony_compiled | benchLongest | 300    | 1.024155 seconds | 292.92443902704 |
| symfony_compiled | benchLast    | 300    | 1.028246 seconds | 291.7589293395  |
| fast_group_pos   | benchAll     | 364    | 2.373667 seconds | 153.34922705485 |
| fast_mark        | benchAll     | 364    | 2.385797 seconds | 152.56955909197 |
| fast_char_count  | benchAll     | 364    | 2.394524 seconds | 152.01350464118 |
| fast_group_count | benchAll     | 364    | 2.454272 seconds | 148.31281752227 |
| symfony          | benchAll     | 364    | 2.937390 seconds | 123.91954031012 |
| fast_mark        | benchLast    | 300    | 2.686658 seconds | 111.66288523543 |
| fast_mark        | benchLongest | 300    | 2.703355 seconds | 110.9732233665  |
| fast_char_count  | benchLongest | 300    | 2.718596 seconds | 110.35107902413 |
| fast_char_count  | benchLast    | 300    | 2.725077 seconds | 110.08863583889 |
| fast_group_pos   | benchLast    | 300    | 2.735245 seconds | 109.67938929169 |
| fast_group_count | benchLongest | 300    | 2.760229 seconds | 108.68663936194 |
| fast_group_count | benchLast    | 300    | 2.789061 seconds | 107.56308957411 |
| fast_group_pos   | benchLongest | 300    | 2.999463 seconds | 100.01790844184 |
| symfony          | benchLast    | 300    | 3.034052 seconds | 98.877668146056 |
| symfony          | benchLongest | 300    | 3.107172 seconds | 96.55082558324  |
+------------------+--------------+--------+------------------+-----------------+
```

## PHP 7.2
```
+------------------+--------------+--------+------------------+-----------------+
| Case             | Scenario     | Routes | Time             | Per Second      |
+------------------+--------------+--------+------------------+-----------------+
| symfony_compiled | benchAll     | 364    | 0.408144 seconds | 891.84210108186 |
| symfony_compiled | benchLast    | 300    | 1.038435 seconds | 288.89627671787 |
| symfony_compiled | benchLongest | 300    | 1.047636 seconds | 286.35899377893 |
| fast_group_pos   | benchAll     | 364    | 2.244482 seconds | 162.17551849955 |
| fast_mark        | benchAll     | 364    | 2.247139 seconds | 161.98373358188 |
| fast_group_count | benchAll     | 364    | 2.288827 seconds | 159.03343029131 |
| fast_char_count  | benchAll     | 364    | 2.354694 seconds | 154.58484926848 |
| symfony          | benchAll     | 364    | 2.780224 seconds | 130.92469847412 |
| fast_group_pos   | benchLast    | 300    | 2.576181 seconds | 116.45144793021 |
| fast_group_pos   | benchLongest | 300    | 2.581738 seconds | 116.20079208806 |
| fast_char_count  | benchLongest | 300    | 2.615559 seconds | 114.6982302458  |
| fast_mark        | benchLongest | 300    | 2.617206 seconds | 114.62605118645 |
| fast_group_count | benchLast    | 300    | 2.637000 seconds | 113.76564944113 |
| fast_char_count  | benchLast    | 300    | 2.641218 seconds | 113.58395215341 |
| fast_mark        | benchLast    | 300    | 2.685192 seconds | 111.72384988358 |
| fast_group_count | benchLongest | 300    | 2.690716 seconds | 111.49448580019 |
| symfony          | benchLast    | 300    | 2.870845 seconds | 104.49885542931 |
| symfony          | benchLongest | 300    | 2.891245 seconds | 103.76152379024 |
+------------------+--------------+--------+------------------+-----------------+
```

## PHP 7.3
```
+------------------+--------------+--------+------------------+-----------------+
| Case             | Scenario     | Routes | Time             | Per Second      |
+------------------+--------------+--------+------------------+-----------------+
| symfony_compiled | benchAll     | 364    | 0.396294 seconds | 918.51027658305 |
| symfony_compiled | benchLongest | 300    | 0.943515 seconds | 317.95994783429 |
| symfony_compiled | benchLast    | 300    | 0.951158 seconds | 315.40499608216 |
| fast_mark        | benchAll     | 364    | 2.160739 seconds | 168.46088734647 |
| fast_char_count  | benchAll     | 364    | 2.222830 seconds | 163.75520873946 |
| fast_group_count | benchAll     | 364    | 2.277991 seconds | 159.78991619418 |
| fast_group_pos   | benchAll     | 364    | 2.384362 seconds | 152.66138392373 |
| symfony          | benchAll     | 364    | 2.796925 seconds | 130.14292165971 |
| fast_char_count  | benchLongest | 300    | 2.486663 seconds | 120.64361609308 |
| fast_mark        | benchLast    | 300    | 2.665786 seconds | 112.53716422071 |
| fast_group_pos   | benchLast    | 300    | 2.669518 seconds | 112.37983811403 |
| fast_group_pos   | benchLongest | 300    | 2.691637 seconds | 111.45633517173 |
| fast_char_count  | benchLast    | 300    | 2.728253 seconds | 109.96048106452 |
| fast_mark        | benchLongest | 300    | 2.812392 seconds | 106.67076296112 |
| fast_group_count | benchLongest | 300    | 2.819193 seconds | 106.413426368   |
| symfony          | benchLast    | 300    | 2.831208 seconds | 105.96183713493 |
| fast_group_count | benchLast    | 300    | 2.893549 seconds | 103.67890904273 |
| symfony          | benchLongest | 300    | 2.918857 seconds | 102.77995460759 |
+------------------+--------------+--------+------------------+-----------------+
```

## PHP 7.4
```
+------------------+--------------+--------+------------------+-----------------+
| Case             | Scenario     | Routes | Time             | Per Second      |
+------------------+--------------+--------+------------------+-----------------+
| symfony_compiled | benchAll     | 364    | 0.359007 seconds | 1013.9081408754 |
| symfony_compiled | benchLongest | 300    | 0.930904 seconds | 322.26741800602 |
| symfony_compiled | benchLast    | 300    | 0.958366 seconds | 313.03283496837 |
| fast_group_count | benchAll     | 364    | 1.953842 seconds | 186.29959311816 |
| fast_group_pos   | benchAll     | 364    | 1.967520 seconds | 185.00447277191 |
| fast_char_count  | benchAll     | 364    | 1.971332 seconds | 184.64674164723 |
| fast_mark        | benchAll     | 364    | 1.987986 seconds | 183.0998728985  |
| symfony          | benchAll     | 364    | 2.469566 seconds | 147.3943273435  |
| fast_group_count | benchLongest | 300    | 2.146927 seconds | 139.73459901953 |
| fast_group_pos   | benchLast    | 300    | 2.220032 seconds | 135.13318868765 |
| fast_group_count | benchLast    | 300    | 2.222863 seconds | 134.96108646633 |
| fast_group_pos   | benchLongest | 300    | 2.284389 seconds | 131.32614344718 |
| fast_char_count  | benchLast    | 300    | 2.307472 seconds | 130.01241238205 |
| fast_mark        | benchLast    | 300    | 2.315931 seconds | 129.53753346169 |
| fast_mark        | benchLongest | 300    | 2.362713 seconds | 126.97267399379 |
| fast_char_count  | benchLongest | 300    | 2.402372 seconds | 124.87658637445 |
| symfony          | benchLast    | 300    | 2.560217 seconds | 117.1775717784  |
| symfony          | benchLongest | 300    | 2.610204 seconds | 114.93354624306 |
+------------------+--------------+--------+------------------+-----------------+
```
