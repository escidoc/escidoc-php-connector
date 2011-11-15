Welcome to the escidoc-PHPConnector Project

Project Structure:
==================

This project is structured in two parts:

src		- The source of this project, use its content as the library in your solution.
test	- The test environment, which shall not become part of your solution implementation.

TODO: build script (batch/shell) to create lib-archive

ClassLoading:
=============

The PHPConnector uses the ClassLoader implementation to autoload classes. Therefore no require/include
-statements are required in the PHP files. In order to use the PHPConnector in your solution, you have to
setup the ClassLoader first. Usually this will be done in the index.php or your main-class. Check the test
files for examples how to do this. The PHPConnector includes the normal ClassLoader itself and therefore you
may use this one for you solution as well.
Because of this ClassLoading, each class has to be located in a PHP file named exactly like the class. If
there are more classes in one PHP file, the ClassLoader will *not* be able to resolve them.

Example: Class \root\b\c\Foo has to be located in file root/b/c/Foo.php.

Depending on the setup of the ClassLoader the directory 'root' can be named differently than its namespace
representation. Read the ClassLoader's registerNamespaces()-documentation for details.

Dependencies:
=============

The PHPConnector requires the following dependencies to be provided by your solution:

- PEAR/HTTP (may get changed to PECL_HTTP for streaming)

Additionally to these dependencies the following dependencies are required when developing this project:

- pear.phpunit.de/PHPUnit (https://github.com/sebastianbergmann/phpunit)