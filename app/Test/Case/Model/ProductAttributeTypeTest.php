<?php
App::uses('ProductAttributeType', 'Model');

/**
 * ProductAttributeType Test Case
 *
 */
class ProductAttributeTypeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.product_attribute_type'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ProductAttributeType = ClassRegistry::init('ProductAttributeType');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ProductAttributeType);

		parent::tearDown();
	}

}
