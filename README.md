# Benchmark PHP Routing

Take a real world routing scenario in the form of [Bitbucket API](https://developer.atlassian.com/bitbucket/api/2/reference/resource/) and benchmark PHP routing packages against it.

To run the benchmarks, first you have to run `composer update` to get all of the
packages and their dependencies. After that, you can execute any of benchmark
files like this:
```sh
php vendor/bin/phpbench run benchmark/Bitbucket_Symfony.php --report=aggregate
```

# Packages

* Symfony Routing [symfony/routing](https://github.com/symfony/routing)
* Fast Route [nikic/fast-route](https://github.com/nikic/fast-route)

# Benchmarks

This is the list of the available benchmarks

| File | Package | Strategy |
|------|---------|----------|
| benchmark/Bitbucket_Symfony.php | Symfony Routing [symfony/routing](https://github.com/symfony/routing) |  `Symfony\Component\Routing\Matcher\UrlMatcher` |


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
