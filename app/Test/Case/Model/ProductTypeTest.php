<?php
App::uses('ProductType', 'Model');

/**
 * ProductType Test Case
 *
 */
class ProductTypeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.product_type'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ProductType = ClassRegistry::init('ProductType');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ProductType);

		parent::tearDown();
	}

}
