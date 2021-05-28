# Benchmark PHP Routing

Take a real world routing scenario in the form of [Bitbucket API](https://developer.atlassian.com/bitbucket/api/2/reference/resource/) and benchmark PHP routing packages against it.

# Packages

* Symfony Routing [symfony/routing](https://github.com/symfony/routing)
* Fast Route [nikic/fast-route](https://github.com/nikic/fast-route)

# Routes

All the routes for this benchmark are read from this address:
https://developer.atlassian.com/bitbucket/api/2/reference/resource/

Only the URLs are used, and the HTTP verbs/methods are ignored.
