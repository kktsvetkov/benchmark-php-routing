# Benchmark PHP Routing

Take a real world routing scenario in the form of [Bitbucket API](https://developer.atlassian.com/bitbucket/api/2/reference/resource/) and benchmark PHP routing packages against it.

You can read more about this here: http://kaloyan.info/writing/2021/05/31/benchmark-php-routing.html

# Packages
Here are the packages that are benchmakred:

* Symfony Routing [symfony/routing](https://github.com/symfony/routing)
* Fast Route [nikic/FastRoute](https://github.com/nikic/FastRoute)

So far these are the most popular ones: **Symfony Routing** component is used not only by
them but by **Laravel** as well, and **FastRoute** is used by other popular solutions such
as the [Slim](https://github.com/slimphp/Slim) framework and [League\Route](https://github.com/thephpleague/route).

# Benchmarks

This is the list of the available [phpbench](https://github.com/phpbench/phpbench)
benchmarks. They are combination of the packages and the strategies they provide.

| Package | File | Strategy |
|---------|------|----------|
| [symfony/routing](https://github.com/symfony/routing) | benchmark/Symfony.php | `Symfony\Component\Routing\Matcher\UrlMatcher` |
| [symfony/routing](https://github.com/symfony/routing) | benchmark/Symfony_Compiled.php | `Symfony\Component\Routing\Matcher\CompiledUrlMatcher` |
| [nikic/FastRoute](https://github.com/nikic/FastRoute) | benchmark/FastRoute_GroupCountBased.php | `FastRoute\Dispatcher\GroupCountBased` |
| [nikic/FastRoute](https://github.com/nikic/FastRoute) | benchmark/FastRoute_GroupPosBased.php | `FastRoute\Dispatcher\GroupPosBased` |
| [nikic/FastRoute](https://github.com/nikic/FastRoute) | benchmark/FastRoute_CharCountBased.php | `FastRoute\Dispatcher\CharCountBased` |
| [nikic/FastRoute](https://github.com/nikic/FastRoute) | benchmark/FastRoute_MarkBased.php | `FastRoute\Dispatcher\MarkBased` |

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
| symfony_compiled | benchAll     | 364    | 0.409297 seconds | 889.329776154   |
| symfony_compiled | benchLast    | 300    | 0.481942 seconds | 622.48162298513 |
| symfony_compiled | benchLongest | 300    | 1.230177 seconds | 243.86731339213 |
| fast_group_count | benchAll     | 364    | 2.854642 seconds | 127.51160408835 |
| fast_group_pos   | benchAll     | 364    | 2.876335 seconds | 126.54992612869 |
| fast_mark        | benchAll     | 364    | 2.888358 seconds | 126.02315411124 |
| fast_char_count  | benchAll     | 364    | 2.902446 seconds | 125.4114619327  |
| fast_group_pos   | benchLast    | 300    | 2.475604 seconds | 121.1825566395  |
| fast_mark        | benchLast    | 300    | 2.496498 seconds | 120.16833808118 |
| fast_char_count  | benchLast    | 300    | 2.507835 seconds | 119.62509918124 |
| fast_group_count | benchLast    | 300    | 2.668138 seconds | 112.43796120841 |
| symfony          | benchAll     | 364    | 3.658297 seconds | 99.49985404727  |
| fast_mark        | benchLongest | 300    | 3.198704 seconds | 93.787984007856 |
| fast_char_count  | benchLongest | 300    | 3.223138 seconds | 93.076999323905 |
| fast_group_pos   | benchLongest | 300    | 3.230840 seconds | 92.855109815605 |
| fast_group_count | benchLongest | 300    | 3.304675 seconds | 90.780482413295 |
| symfony          | benchLongest | 300    | 3.723648 seconds | 80.566152938331 |
| symfony          | benchLast    | 300    | 4.979773 seconds | 60.243709364656 |
+------------------+--------------+--------+------------------+-----------------+
```

## PHP 7.2
```
+------------------+--------------+--------+------------------+-----------------+
| Case             | Scenario     | Routes | Time             | Per Second      |
+------------------+--------------+--------+------------------+-----------------+
| symfony_compiled | benchAll     | 364    | 0.360886 seconds | 1008.6284926794 |
| symfony_compiled | benchLast    | 300    | 0.442319 seconds | 678.24365843404 |
| symfony_compiled | benchLongest | 300    | 0.992547 seconds | 302.25267856885 |
| fast_mark        | benchAll     | 364    | 2.034539 seconds | 178.91030980931 |
| fast_group_pos   | benchAll     | 364    | 2.083953 seconds | 174.66805480364 |
| fast_char_count  | benchAll     | 364    | 2.116721 seconds | 171.9640966591  |
| fast_group_count | benchAll     | 364    | 2.168229 seconds | 167.8789383841  |
| fast_mark        | benchLast    | 300    | 1.850838 seconds | 162.08874507808 |
| fast_char_count  | benchLast    | 300    | 1.862375 seconds | 161.08463473807 |
| fast_group_pos   | benchLast    | 300    | 1.904495 seconds | 157.52207271104 |
| fast_group_count | benchLast    | 300    | 1.929290 seconds | 155.49761376288 |
| symfony          | benchAll     | 364    | 2.519544 seconds | 144.47059326726 |
| fast_group_pos   | benchLongest | 300    | 2.380750 seconds | 126.01070142075 |
| fast_group_count | benchLongest | 300    | 2.410906 seconds | 124.43454472688 |
| fast_char_count  | benchLongest | 300    | 2.416596 seconds | 124.14155215417 |
| fast_mark        | benchLongest | 300    | 2.454727 seconds | 122.21317436736 |
| symfony          | benchLongest | 300    | 2.693696 seconds | 111.37114119265 |
| symfony          | benchLast    | 300    | 3.420336 seconds | 87.710680848901 |
+------------------+--------------+--------+------------------+-----------------+
```

## PHP 7.3
```
+------------------+--------------+--------+------------------+-----------------+
| Case             | Scenario     | Routes | Time             | Per Second      |
+------------------+--------------+--------+------------------+-----------------+
| symfony_compiled | benchAll     | 364    | 0.333783 seconds | 1090.5283873862 |
| symfony_compiled | benchLast    | 300    | 0.383387 seconds | 782.49945119558 |
| symfony_compiled | benchLongest | 300    | 0.921058 seconds | 325.7124086605  |
| fast_mark        | benchAll     | 364    | 2.041492 seconds | 178.30096939752 |
| fast_group_pos   | benchAll     | 364    | 2.126128 seconds | 171.20324229753 |
| fast_group_count | benchAll     | 364    | 2.152566 seconds | 169.1005095411  |
| fast_char_count  | benchAll     | 364    | 2.172326 seconds | 167.56233880761 |
| fast_char_count  | benchLast    | 300    | 1.876143 seconds | 159.90252523982 |
| fast_group_count | benchLast    | 300    | 1.878880 seconds | 159.66958835844 |
| fast_group_pos   | benchLast    | 300    | 1.904677 seconds | 157.50702796943 |
| fast_mark        | benchLast    | 300    | 1.913834 seconds | 156.75339925419 |
| symfony          | benchAll     | 364    | 2.562547 seconds | 142.04617690139 |
| fast_char_count  | benchLongest | 300    | 2.394527 seconds | 125.28570577975 |
| fast_group_count | benchLongest | 300    | 2.419258 seconds | 124.00496969431 |
| fast_mark        | benchLongest | 300    | 2.433419 seconds | 123.28333153219 |
| fast_group_pos   | benchLongest | 300    | 2.499992 seconds | 120.00038910038 |
| symfony          | benchLongest | 300    | 2.713896 seconds | 110.54218584799 |
| symfony          | benchLast    | 300    | 3.544668 seconds | 84.634161352191 |
+------------------+--------------+--------+------------------+-----------------+
```

## PHP 7.4
```
+------------------+--------------+--------+------------------+-----------------+
| Case             | Scenario     | Routes | Time             | Per Second      |
+------------------+--------------+--------+------------------+-----------------+
| symfony_compiled | benchAll     | 364    | 0.334722 seconds | 1087.4702395071 |
| symfony_compiled | benchLast    | 300    | 0.391615 seconds | 766.05866967986 |
| symfony_compiled | benchLongest | 300    | 0.918377 seconds | 326.66326060138 |
| fast_group_pos   | benchAll     | 364    | 1.836413 seconds | 198.2125036709  |
| fast_char_count  | benchAll     | 364    | 1.854658 seconds | 196.26261116629 |
| fast_group_count | benchAll     | 364    | 1.894953 seconds | 192.08919567152 |
| fast_mark        | benchAll     | 364    | 1.907493 seconds | 190.82637690195 |
| fast_mark        | benchLast    | 300    | 1.670489 seconds | 179.58812475032 |
| fast_char_count  | benchLast    | 300    | 1.686217 seconds | 177.91303706026 |
| fast_group_pos   | benchLast    | 300    | 1.698040 seconds | 176.67428240226 |
| fast_group_count | benchLast    | 300    | 1.705245 seconds | 175.9277973736  |
| symfony          | benchAll     | 364    | 2.359127 seconds | 154.29436105241 |
| fast_mark        | benchLongest | 300    | 2.150827 seconds | 139.48123657748 |
| fast_group_count | benchLongest | 300    | 2.189247 seconds | 137.03341011817 |
| fast_char_count  | benchLongest | 300    | 2.192200 seconds | 136.84883106702 |
| fast_group_pos   | benchLongest | 300    | 2.279765 seconds | 131.59250318029 |
| symfony          | benchLongest | 300    | 2.453912 seconds | 122.2537717685  |
| symfony          | benchLast    | 300    | 3.199316 seconds | 93.77004262047  |
+------------------+--------------+--------+------------------+-----------------+
```

# More Benchmarks

[Saif Eddin Gmati](https://github.com/azjezz) created a fork in which there are
benchmark cases included, which re-use the created dispatch objects. This is an
interesting approach and one that is used with solutions like Swoole and ReactPHP:

https://github.com/azjezz/benchmark-php-routing
