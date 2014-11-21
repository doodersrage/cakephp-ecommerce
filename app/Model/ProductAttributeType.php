<?php
App::uses('AppModel', 'Model');
/**
 * ProductAttributeType Model
 *
 */
class ProductAttributeType extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'product_attribute_types';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'title';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'title' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
}
