<?php
App::uses('ProductAttribute', 'Model');

/**
 * ProductAttribute Test Case
 *
 */
class ProductAttributeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.product_attribute'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ProductAttribute = ClassRegistry::init('ProductAttribute');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ProductAttribute);

		parent::tearDown();
	}

}
