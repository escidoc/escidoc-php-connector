<?php
class ClassLoader
{
	private $namespaces = array();

	/**
	 * Registers an array of namespaces (namespaces as keys and locations as values)
	 * In order to find a file, the location of a namespace will be used and because of that, you can
	 * substitute any directory with one namespace.
	 *
	 * Example: registerNamespaces(array('foo' => __DIR__.'/lib/bar'));
	 *
	 * In this example, the location __DIR__.'/lib/bar' will substitute the namespace 'foo' and therefore
	 * the namespace 'foo/x/y' will result in __DIR__.'/lib/bar/x/y' to locate the php files.
	 *
	 * @param array $namespaces An array of namespaces
	 *
	 * @api
	 */
	public function registerNamespaces(array $namespaces)
	{
		foreach ($namespaces as $namespace => $locations) {
			$this->namespaces[$namespace] = (array) $locations;
		}
	}

	/**
	 * Registers this instance as an autoloader.
	 *
	 * @param Boolean $prepend Whether to prepend the autoloader or not
	 *
	 * @api
	 */
	public function register($prepend = false)
	{
		spl_autoload_register(array($this, 'loadClass'), true, $prepend);
	}

	/**
	 * Loads the given class or interface.
	 *
	 * @param string $class The name of the class
	 */
	public function loadClass($class)
	{
		if ($file = $this->findFile($class)) {
			require $file;
		}
	}

	/**
	 * Finds the path to the file where the class is defined.
	 *
	 * @param string $class The name of the class
	 *
	 * @return string|null The path, if found
	 */
	public function findFile($class)
	{
		if ('\\' == $class[0]) {
			$class = substr($class, 1);
		}

		if (false !== $pos = strrpos($class, '\\')) {

			// namespaced class name
			$namespace = substr($class, 0, $pos);
			foreach ($this->namespaces as $ns => $dirs) {
				foreach ($dirs as $dir) {
					if (0 === strpos($namespace, $ns)) {
						$className = substr($class, $pos + 1);
						// remove leading namespace part because it will be replaced by its directory name
						$namespaceSuffix = substr($namespace, strlen($ns));
						$file = $dir.str_replace('\\', DIRECTORY_SEPARATOR, $namespaceSuffix).DIRECTORY_SEPARATOR.str_replace('_', DIRECTORY_SEPARATOR, $className).'.php';
						if (file_exists($file)) {
							return $file;
						}
					}
				}
			}
		}
	}
}

final class PHPConnectorClassLoader extends ClassLoader {

	private static $cl = null;

	public static final function init() {
		if (self::$cl == null) {
			self::$cl = new PHPConnectorClassLoader();
		}
		self::$cl->registerNamespaces(array('escidoc'=>__DIR__));
		self::$cl->register();
	}

	private function __construct(){}
}

PHPConnectorClassLoader::init();
?>