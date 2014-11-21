<?php
App::uses('Address', 'Model');

/**
 * Address Test Case
 *
 */
class AddressTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.address',
		'app.user_is'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Address = ClassRegistry::init('Address');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Address);

		parent::tearDown();
	}

}
