<?php
use escidoc\client\exceptions\server\EscidocException;

require_once 'PHPUnit/Autoload.php';
require_once 'PHPUnit/Framework/TestCase.php';
require_once '../../src/ClassLoader.php';

class ExceptionClassLoadingTest extends PHPUnit_Framework_TestCase {

	private static $EX_MSG = "TEST";

	protected function setUp() {

	}

	protected function tearDown() {

	}

	public function testEscidocExceptionClassLoading() {
		// test if all EsciDocExceptions are valid EsciDocException classes
		$iterator = new RecursiveIteratorIterator(
		new RecursiveDirectoryIterator(__DIR__.'/../../src/client/exceptions/server/'),
		RecursiveIteratorIterator::CHILD_FIRST);

		foreach ($iterator as $fileinfo) {
			if ($fileinfo->isFile()) {
				$pathInfo = pathinfo($fileinfo->getFilename());
				if(array_key_exists('extension', $pathInfo) && $pathInfo['extension'] == 'php') {
					// create namespace to create reflection class
					$path = $fileinfo->getPathname();
					$path = substr($path, strpos($path, 'client/exceptions/server'));
					// add escidoc-namespace prefix & remove .php extension
					$path = 'escidoc'.DIRECTORY_SEPARATOR.substr($path, 0, strlen($path)-4);
					// replace DIRECTORY_SEPARATOR with backslashes
					if (DIRECTORY_SEPARATOR == '/') {
						$path = str_replace('/', '\\', $path);
					}
					$this->throwEscidocException(new ReflectionClass($path));
				}
			}
		}
	}

	private function throwEscidocException(ReflectionClass $class) {
		try {
			throw $class->newInstance(self::$EX_MSG);
		} catch (EscidocException $e) {
			$this->assertEquals($e->getMessage(), self::$EX_MSG);
		} catch (Exception $e) {
			$this->fail("Invalid EscidocException class: ".$class->getName());
		}
	}
}
?>