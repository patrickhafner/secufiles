<?php
App::uses('Secufile', 'Model');

/**
 * Secufile Test Case
 *
 */
class SecufileTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.secufile'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Secufile = ClassRegistry::init('Secufile');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Secufile);

		parent::tearDown();
	}

}
