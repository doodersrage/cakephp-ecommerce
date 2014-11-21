<?php
/**
 * OrdersProductFixture
 *
 */
class OrdersProductFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'ordersProducts';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => false, 'key' => 'primary'),
		'orderId' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => false),
		'productId' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => false),
		'price' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2', 'unsigned' => false),
		'quantity' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => false),
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
			'orderId' => 1,
			'productId' => 1,
			'price' => 1,
			'quantity' => 1,
			'total' => 1
		),
	);

}
