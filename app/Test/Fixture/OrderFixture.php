<?php
/**
 * OrderFixture
 *
 */
class OrderFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => false, 'key' => 'primary'),
		'shipAddressId' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => false),
		'billAddressId' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => false),
		'subTotal' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2', 'unsigned' => false),
		'tax' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2', 'unsigned' => false),
		'shipping' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2', 'unsigned' => false),
		'total' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2', 'unsigned' => false),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'shipAddressId' => 1,
			'billAddressId' => 1,
			'subTotal' => 1,
			'tax' => 1,
			'shipping' => 1,
			'total' => 1
		),
	);

}
