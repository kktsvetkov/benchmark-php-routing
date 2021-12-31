<?php

namespace Benchmark_Routing\Generate;

use function basename;
use function file_put_contents;
use function preg_replace;
use function printf;
use function rtrim;
use function trim;

abstract class GenerateAbstract
{
	protected $folder =  __DIR__ . '/../routes/benchmark/';

	protected $generated = 'routes.php';

	protected $contents = '<?php ';

	function __construct(array $api)
	{
		$this->contents = $this->generate($api);
	}

	function route($route)
	{
		return rtrim($route);
	}

	function name($route)
	{
		$name = preg_replace('#\W+#', '_', $this->route($route));
		$name = trim($name, '_');
		return $name;
	}

	function __destruct()
	{
		file_put_contents(
			$this->folder . DIRECTORY_SEPARATOR . $this->generated,
			$this->contents
			);

		printf("%s done.\n", $this->generated);
	}
}
