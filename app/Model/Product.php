<?php
App::uses('AppModel', 'Model');
/**
 * Product Model
 *
 */
class Product extends AppModel {

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'itemNumber';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'itemNumber';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'itemNumber' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'price' => array(
			'money' => array(
				'rule' => array('money'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'quantity' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'prodType' => array(
			'valid' => array(
                'rule' => array('inList', array('standard')),
                'message' => 'Please enter a valid product type',
                'allowEmpty' => false
            ),
		),
	);
}
