<?php

namespace Benchmark_Routing\Benchmark\Symfony;

use Benchmark_Routing\Benchmark\Symfony\UrlMatcher_Benchmark;
use Benchmark_Routing\Kit\Provider\ProviderAbstract;
use Symfony\Component\Routing\Matcher\CompiledUrlMatcher;
use Symfony\Component\Routing\Matcher\Dumper\CompiledUrlMatcherDumper;
use Symfony\Component\Routing\RequestContext;

use function dirname;
use function is_file;
use function var_export;

class CompiledUrlMatcher_Benchmark extends UrlMatcher_Benchmark
{
	protected $compiledRoutes = array();

	protected function setupProvider(ProviderAbstract $provider)
	{
		parent::setupProvider($provider);

		$providerName = $provider->name();
		$this->compiledRoutes[ $providerName ] = dirname(__FILE__, 3)
			. "/routes/cache/symfony/{$providerName}.php";

		if (!is_file($this->compiledRoutes[ $providerName ]))
		{

			$dumper = new CompiledUrlMatcherDumper(
				include $this->getRoutesFilename(
					$providerName
					)
				);

			$compiled = $dumper->getCompiledRoutes();

			$this->writeFile(
				$this->compiledRoutes[ $providerName ],
				'<?php return ' . var_export($compiled, true) . ';'
				);
		}

	}

	function setupRouting( $providerName )
	{
		return new CompiledUrlMatcher(
			include $this->compiledRoutes[ $providerName ],
			new RequestContext()
			);
	}
}
