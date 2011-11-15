<?php
require_once 'PHPUnit/Autoload.php';

require_once 'PHPUnit/Framework/TestCase.php';

class MyFirstTest extends PHPUnit_Framework_TestCase {

	protected $fixture;

	protected function setUp() {
		// Array-Fixture erzeugen.
		$this->fixture = array();
	}

	public function testNewArrayIsEmpty() {
		// Der erwartete Wert von sizeof($this->fixture) ist 0.
		$this->assertEquals(0, sizeof($this->fixture));
	}

	public function testArrayContainsAnElement() {
		// Ein Element dem Array hinzufügen.
		$this->fixture[] = 'Element';

		// Der erwartete Wert von sizeof($this->fixture) ist 1.
		$this->assertEquals(1, sizeof($this->fixture));
	}
}
?>