<?php 
class AppSchema extends CakeSchema {

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
		// add initial admin user record
		if (isset($event['create'])) {
	        switch ($event['create']) {
	        	// generate initial admin user
	            case 'users':
	                App::uses('ClassRegistry', 'Utility');
	                $user = ClassRegistry::init('User');

	                $user->create();
	                $user->save(
	                    array(
                        	'email' => 'rob@studiocenter.com',
                        	'username' => 'admin',
                        	'password' => 'production1',
                        	'role' => 'admin',
	                    )
	                );
	                break;
	        }
	    }
	}

	public $content = array(
			'id' => array(
	            'type' => 'integer',
	            'null' => false,
	            'default' => null,
	            'length' => 10,
	            'key' => 'primary'
	        ),
	        'sortOrder' => array(
	            'type' => 'integer',
	            'null' => true,
	            'default' => 0,
	            'length' => 10,
	        ),
	        'title' => array(
	        	'type' => 'string', 
	        	'null' => false, 
	        	'length' => 255,
        	),
        	'header' => array(
	        	'type' => 'string', 
	        	'null' => true, 
	        	'length' => 255,
        	),
	        'content' => array(
	        	'type' => 'text', 
	        	'null' => true
	        ),
	        'pageImage' => array(
	        	'type' => 'string', 
	        	'null' => true, 
	        	'length' => 255,
        	),
	        'csvFile' => array(
	        	'type' => 'string', 
	        	'null' => true, 
	        	'length' => 255,
        	),
        	'sefURL' => array(
	        	'type' => 'string', 
	        	'null' => true, 
	        	'length' => 255,
        	),
        	'titleTag' => array(
	        	'type' => 'string', 
	        	'null' => true, 
	        	'length' => 255,
        	),
        	'metaDescription' => array(
	        	'type' => 'text', 
	        	'null' => true
	        ),
	        'vendorId' => array(
	            'type' => 'integer',
	            'null' => true,
	            'default' => null,
	            'length' => 10,
	        ),
	        'parentId' => array(
	            'type' => 'integer',
	            'null' => true,
	            'default' => null,
	            'length' => 10,
	        ),
	        'productListType' => array(
	        	'type' => 'text', 
	        	'null' => true
	        ),
	        'indexes' => array(
		        'PRIMARY' => array('column' => 'id', 'unique' => true),
		    ),
		);
	
	public $vendors = array(
			'id' => array(
	            'type' => 'integer',
	            'null' => false,
	            'default' => null,
	            'length' => 10,
	            'key' => 'primary'
	        ),
	        'name' => array(
	        	'type' => 'string', 
	        	'null' => false, 
	        	'length' => 100,
        	),
        	'contactName' => array(
	        	'type' => 'string', 
	        	'null' => true, 
	        	'length' => 100,
        	),
        	'telephone' => array(
	        	'type' => 'string', 
	        	'null' => false, 
	        	'length' => 100,
        	),
        	'fax' => array(
	        	'type' => 'string', 
	        	'null' => true, 
	        	'length' => 100,
        	),
	        'address' => array(
	        	'type' => 'string', 
	        	'null' => false, 
	        	'length' => 100,
        	),
        	'address2' => array(
	        	'type' => 'string', 
	        	'null' => true, 
	        	'length' => 100,
        	),
        	'city' => array(
	        	'type' => 'string', 
	        	'null' => false, 
	        	'length' => 100,
        	),
        	'state' => array(
	        	'type' => 'string', 
	        	'null' => false, 
	        	'length' => 100,
        	),
        	'postalCode' => array(
	        	'type' => 'string', 
	        	'null' => false, 
	        	'length' => 100,
        	),
	        'indexes' => array(
		        'PRIMARY' => array('column' => 'id', 'unique' => true),
		    ),
		);

	public $products = array(
	        'itemNumber' => array(
	        	'type' => 'string', 
	        	'null' => false, 
	        	'length' => 100,
	        	'key' => 'primary',
	        ),
	        'price' => array(
	        	'type' => 'float', 
	        	'null' => false, 
	        	'length' => '10,2',
        	),
	        'quantity' => array(
	        	'type' => 'integer', 
	        	'null' => false, 
	        	'length' => 10,
        	),
	        'minQty' => array(
	        	'type' => 'integer', 
	        	'null' => false, 
	        	'length' => 10,
        	),
        	'prodType' => array(
	        	'type' => 'string', 
	        	'null' => false, 
	        	'length' => 100,
        	),
        	'contentId' => array(
	        	'type' => 'integer', 
	        	'null' => false, 
	        	'length' => 10,
        	),
	        'indexes' => array(
		        'PRIMARY' => array('column' => 'itemNumber', 'unique' => true),
		    ),
        );

	public $product_types = array(
			'id' => array(
	            'type' => 'integer',
	            'null' => false,
	            'default' => null,
	            'length' => 10,
	            'key' => 'primary'
	        ),
	        'title' => array(
	        	'type' => 'string', 
	        	'null' => false, 
	        	'length' => 100,
        	),
        	'attributes' => array(
	        	'type' => 'text', 
	        	'null' => true,
	        ),
        	'custDimension' => array(
	        	'type' => 'boolean', 
				'length' => 1,
			    'default' => 0,
	        	'null' => true,
	        ),
	        'indexes' => array(
		        'PRIMARY' => array('column' => 'id', 'unique' => true),
		    ),
		);

	public $product_attributes = array(
			'id' => array(
	            'type' => 'integer',
	            'null' => false,
	            'default' => null,
	            'length' => 10,
	            'key' => 'primary'
	        ),
	        'attributeId' => array(
	            'type' => 'integer',
	            'null' => false,
	            'default' => null,
	            'length' => 10,
	        ),
	        'itemNumber' => array(
	        	'type' => 'string', 
	        	'null' => false, 
	        	'length' => 100,
	        ),
	        'content' => array(
	        	'type' => 'text', 
	        	'null' => false
	        ),
	        'indexes' => array(
		        'PRIMARY' => array('column' => 'id', 'unique' => true),
		    ),
	        // 'material' => array(
	        // 	'type' => 'string', 
	        // 	'null' => false, 
	        // 	'length' => 100,
        	// ),
	        // 'size' => array(
	        // 	'type' => 'string', 
	        // 	'null' => false, 
	        // 	'length' => 100,
        	// ),
	        // 'thickness' => array(
	        // 	'type' => 'float', 
	        // 	'null' => false, 
	        // 	'length' => '10,2',
        	// ),
	        // 'quality' => array(
	        // 	'type' => 'string', 
	        // 	'null' => false, 
	        // 	'length' => 100,
        	// ),
	        // 'flatness' => array(
	        // 	'type' => 'string', 
	        // 	'null' => false, 
	        // 	'length' => 100,
        	// ),
	        // 'roughness' => array(
	        // 	'type' => 'string', 
	        // 	'null' => false, 
	        // 	'length' => 100,
        	// ),
	        // 'ttv' => array(
	        // 	'type' => 'string', 
	        // 	'null' => false, 
	        // 	'length' => 100,
        	// ),
	        // 'orientation' => array(
	        // 	'type' => 'string', 
	        // 	'null' => false, 
	        // 	'length' => 100,
        	// ),
	        // 'thickness_tol' => array(
	        // 	'type' => 'string', 
	        // 	'null' => false, 
	        // 	'length' => 100,
        	// ),
	        // 'dimension_tol' => array(
	        // 	'type' => 'string', 
	        // 	'null' => false, 
	        // 	'length' => 100,
        	// ),
	        // 'grade' => array(
	        // 	'type' => 'string', 
	        // 	'null' => false, 
	        // 	'length' => 100,
        	// ),
		);

	public $product_attribute_types = array(
			'id' => array(
	            'type' => 'integer',
	            'null' => false,
	            'default' => null,
	            'length' => 10,
	            'key' => 'primary'
	        ),
	        'title' => array(
	        	'type' => 'string', 
	        	'null' => false, 
	        	'length' => 100,
        	),
	        'indexes' => array(
		        'PRIMARY' => array('column' => 'id', 'unique' => true),
		    ),
		);
	
	public $users = array(
			'id' => array(
	            'type' => 'integer',
	            'null' => false,
	            'default' => null,
	            'length' => 10,
	            'key' => 'primary'
	        ),
	        'email' => array(
	        	'type' => 'string', 
	        	'null' => false, 
	        	'length' => 255,
        	),
	        'username' => array(
	        	'type' => 'string', 
	        	'null' => false, 
	        	'length' => 50,
        	),
        	'password' => array(
	        	'type' => 'string', 
	        	'null' => false, 
	        	'length' => 255,
        	),
        	'role' => array(
	        	'type' => 'string', 
	        	'null' => false, 
	        	'length' => 20,
        	),
        	'created' => array(
	        	'type' => 'datetime', 
	        	'null' => true, 
        	),
        	'modified' => array(
	        	'type' => 'datetime', 
	        	'null' => true, 
        	),
	        'indexes' => array(
		        'PRIMARY' => array('column' => 'id', 'unique' => true),
		    ),
		);

	public $addresses = array(
			'id' => array(
	            'type' => 'integer',
	            'null' => false,
	            'default' => null,
	            'length' => 10,
	            'key' => 'primary'
	        ),
	        'userId' => array(
	            'type' => 'integer',
	            'null' => false,
	            'default' => null,
	            'length' => 10,
	            'key' => 'primary'
	        ),
	        'firstName' => array(
	        	'type' => 'string', 
	        	'null' => false, 
	        	'length' => 100,
        	),
        	'lastName' => array(
	        	'type' => 'string', 
	        	'null' => false, 
	        	'length' => 100,
        	),
        	'company' => array(
	        	'type' => 'string', 
	        	'null' => true, 
	        	'length' => 100,
        	),
        	'telephone' => array(
	        	'type' => 'string', 
	        	'null' => false, 
	        	'length' => 100,
        	),
        	'fax' => array(
	        	'type' => 'string', 
	        	'null' => true, 
	        	'length' => 100,
        	),
	        'address' => array(
	        	'type' => 'string', 
	        	'null' => false, 
	        	'length' => 100,
        	),
        	'address2' => array(
	        	'type' => 'string', 
	        	'null' => true, 
	        	'length' => 100,
        	),
        	'city' => array(
	        	'type' => 'string', 
	        	'null' => false, 
	        	'length' => 100,
        	),
        	'state' => array(
	        	'type' => 'string', 
	        	'null' => false, 
	        	'length' => 100,
        	),
        	'postalCode' => array(
	        	'type' => 'string', 
	        	'null' => false, 
	        	'length' => 100,
        	),
			'indexes' => array(
		        'PRIMARY' => array('column' => 'id', 'unique' => true),
		    ),
		);

	public $orders = array(
	        'id' => array(
	            'type' => 'integer',
	            'null' => false,
	            'default' => null,
	            'length' => 10,
	            'key' => 'primary'
	        ),
	        'shipAddress' => array(
	            'type' => 'text',
	            'null' => false,
	        ),
	        'billAddress' => array(
	            'type' => 'text',
	            'null' => false,
	        ),
	        'products' => array(
	            'type' => 'text',
	            'null' => false,
	        ),
        	'subTotal' => array(
	        	'type' => 'float', 
	        	'null' => false, 
	        	'length' => '10,2',
        	),
        	'tax' => array(
	        	'type' => 'float', 
	        	'null' => false, 
	        	'length' => '10,2',
        	),
        	'shipping' => array(
	        	'type' => 'float', 
	        	'null' => false, 
	        	'length' => '10,2',
        	),
        	'total' => array(
	        	'type' => 'float', 
	        	'null' => false, 
	        	'length' => '10,2',
        	),
        	'indexes' => array(
		        'PRIMARY' => array('column' => 'id', 'unique' => true),
		    ),
        );

}
