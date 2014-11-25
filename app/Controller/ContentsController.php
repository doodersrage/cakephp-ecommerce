<?php
App::uses('AppController', 'Controller');
/**
 * Contents Controller
 *
 * @property Content $Content
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class ContentsController extends AppController {

	public $helpers = array(
        'Wysiwyg.Wysiwyg' => array(
            '_editor' => 'Tinymce',
            'theme_advanced_toolbar_align' => 'right',
        )
    );

	public function beforeFilter() {
		// ensure parent class before filter is callled
		parent::beforeFilter();
			
		// assign admin layout for admin users
		if (isset($this->params['prefix']) && $this->params['prefix'] == 'admin') {
	        $this->layout = 'admin';
	    }
	    // allow default access to actions
	    $this->Auth->allow('menu','view','display');
	}

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Content->recursive = 0;
		$this->set('contents', $this->Paginator->paginate());
	}

	// display requested front-end page
	public function display() {
			$path = func_get_args();

			// if SEF page url assigned look up and load page
			if (!empty($path[0])) {
				// if supplied value is an integer searvh for page by index value
				if(is_int($path[0])){
					if (!$this->Content->exists($path[0])) {
						throw new NotFoundException(__('Invalid content'));
					}
					$options = array('conditions' => array('Content.' . $this->Content->primaryKey => $id));
					$content = $this->Content->find('first', $options);
					if($content){
						// set page title
						if($content['Content']['titleTag']){
							$this->set('title_for_layout', $content['Content']['titleTag']);
						} else {
							$this->set('title_for_layout', $content['Content']['title']);
						}
						// gather associated product data
						$this->gatherProducts($content['Content']['id'],$content['Content']['productListType']);
						// store page content
						$this->set('content', $content);
					} else {
						throw new NotFoundException(__('Invalid content'));
					}
				// if else or string is provided looks for page using SEF URL
				} else {
					$options = array('conditions' => array('Content.sefURL' => trim($path[0])));
					$content = $this->Content->find('first', $options);
					if($content){
						// set page title
						if($content['Content']['titleTag']){
							$this->set('title_for_layout', $content['Content']['titleTag']);
						} else {
							$this->set('title_for_layout', $content['Content']['title']);
						}
						// gather associated product data
						$this->gatherProducts($content['Content']['id'],$content['Content']['productListType']);
						// store page content
						$this->set('content', $content);
					} else {
						throw new NotFoundException(__('Invalid content'));
					}
				}
			} else {
				throw new NotFoundException(__('Invalid content'));
			}
	}

	// gather product list information for selected page
	public function gatherProducts($idx,$productListType){
		// load needed data models
		$this->loadModel('ProductAttribute');
		$this->loadModel('ProductAttributeType');
		$this->loadModel('ProductType');
		$this->loadModel('Product');

		// load products data
		$options = array('conditions' => array('Product.contentId' => $idx));
		$products = $this->Product->find('all', $options);

		// continue loading attribute if products have been found
		if($products){

			// store products for view
			$this->set('products', $products);

			// gather product attributes
			$productAttributes = array();
			$selAttributes = array();
			foreach($products as $product){

				$options = array('conditions' => array('ProductAttribute.itemNumber' => $product['Product']['itemNumber']));
				$selAttributes = $this->ProductAttribute->find('all', $options);

				// convert to multi-dimensional array
				foreach($selAttributes as $prodAttrSel){
					$productAttributes[$product['Product']['itemNumber']][$prodAttrSel['ProductAttribute']['attributeId']] = $prodAttrSel;
				}

			}
			// store attributes for view
			if($productAttributes){
				
				$this->set('productAttributes',$productAttributes);

				// retrieve product types
				$options = array('conditions' => array('ProductType.id' => $productListType));
				$productType = $this->ProductType->find('first', $options);
				$this->set('productType',$productType);

				// gather attribute headers
				$attributes = $this->ProductAttributeType->find('all');
				$attrArr = array();
				foreach($attributes as $attribute){
					$attrArr[$attribute['ProductAttributeType']['id']] = $attribute['ProductAttributeType']['title'];
				}
				$this->set('attributes', $attrArr);
			}
		}

	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Content->recursive = 0;
		$this->set('contents', $this->Paginator->paginate());
	}

	function getLines($file) {
	    $linecount = 0;
	    $handle = fopen($file, "r");
	    while(!feof($handle)){
	        if (fgets($handle) !== false) {
	                $linecount++;
	        }
	    }
	    fclose($handle);
	    return  $linecount;     
	}

	// AJAX call for importing products through assigned CSV
	public function admin_import_products($id = null){
		ini_set('auto_detect_line_endings', true);
		// disable layout and view
		$this->autoRender = false;
		$id = $this->request->data('id');

		// check for existing content
		if (!$this->Content->exists($id)) {
			throw new NotFoundException(__('Invalid content'));
		}

		// load content data
		$options = array('conditions' => array('Content.' . $this->Content->primaryKey => $id));
		$content = $this->Content->find('first', $options);

		// check for existing csv file for selected content
		if(!$content['Content']['csvFile']){
			throw new NotFoundException(__('CSV file not found'));
		}

		// process CSV
		$filename = WWW_ROOT . $this->uploadDir . DS . Inflector::slug(pathinfo($content['Content']['csvFile'], PATHINFO_FILENAME)).'.'.pathinfo($content['Content']['csvFile'], PATHINFO_EXTENSION);

		// open the file
        $handle = fopen($filename, 'rb');

        // gather process information for indicator
        $csvLineCnt = $this->getLines($filename);

        // load needed data models
		$this->loadModel('ProductAttribute');
		$this->loadModel('ProductAttributeType');
		$this->loadModel('ProductType');
		$this->loadModel('Product');
        
        // read each data row in the file
        $i = 0;
        $attrTypesArr = array();
        while (($row = fgetcsv($handle)) !== FALSE) {
        	// gather CSV headers
        	if($i === 0){
        		foreach($row as $idx => $clm){

        			// check for column in attributes
        			$prodAttr = $this->ProductAttributeType->find('first', array(
				        'conditions' => array('UPPER(ProductAttributeType.title)' => strtoupper(trim($clm)) )
				    ));

        			// store found product attribute types into an two dimensional array
				    if($prodAttr) {
				    	$attrTypesArr[$idx] = array(trim($clm),$prodAttr['ProductAttributeType']['id']);
				    }

        		}
        	} else {

	        	// perform product additions based on assigned page product type
	        	switch($content['Content']['productListType']){
	        		case 1:

	        			// store non-attribute data for easy access
	        			$itemNumber = trim($row[0]);
	        			$quantity = trim($row[5]);
	        			$priceEach = trim($row[6]);

	        			// save product to database
	        			$options = array('conditions' => array(
        													'Product.itemNumber' => $itemNumber, 
        													));
						$product = $this->Product->find('first', $options);
						if(!$product){
        					$this->Product->create();
        				} else {
        					$this->Product->itemNumber = $itemNumber;
        				}
		                $this->Product->save(
		                    array(
	                        	'itemNumber' => $itemNumber,
	                        	'price' => $priceEach,
	                        	'quantity' => $quantity,
	                        	'prodType' => $content['Content']['productListType'],
	                        	'contentId' => $content['Content']['id'],
		                    )
		                );
		                $this->Product->clear();

		                // assign product attributes
		                foreach($attrTypesArr as $idx => $val){
		                	
		                	// gather selected attribute data
		                	$attributeVal = trim($row[$idx]);

		        			// save attribute to database
		        			$options = array('conditions' => array(
	        													'ProductAttribute.attributeId' => $val[1], 
	        													'ProductAttribute.itemNumber' => $itemNumber,
	        													));
							$attribute = $this->ProductAttribute->find('first', $options);
							if(!$attribute){
			        			$this->ProductAttribute->create();
			            	} else {
			            		$this->ProductAttribute->id = $attribute['ProductAttribute']['id'];
			            	}
			                $this->ProductAttribute->save(
			                    array(
		                        	'attributeId' => $val[1],
		                        	'itemNumber' => $itemNumber,
		                        	'content' => $attributeVal,
			                    )
			                );
			                $this->ProductAttribute->clear();

		                }

	        		break;
	        	}

        	}

        	++$i;
        }

        fclose($handle);

        echo $csvLineCnt." Lines read and products imported!";

	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Content->exists($id)) {
			throw new NotFoundException(__('Invalid content'));
		}
		$options = array('conditions' => array('Content.' . $this->Content->primaryKey => $id));
		$this->set('content', $this->Content->find('first', $options));
	}

	/**
	 * Upload Directory relative to WWW_ROOT
	 * @param string
	 */
	public $uploadDir = 'files/uploads/content';

	// upload selected file
	public function uploadFile($fieldName){

		if (!empty($this->request->data['Content'][$fieldName]['tmp_name'])) {

			// check file is uploaded
			if (is_uploaded_file($this->request->data['Content'][$fieldName]['tmp_name'])) {
					//return FALSE;

				// build full filename
				$filename = WWW_ROOT . $this->uploadDir . DS . Inflector::slug(pathinfo($this->request->data['Content'][$fieldName]['name'], PATHINFO_FILENAME)).'.'.pathinfo($this->request->data['Content'][$fieldName]['name'], PATHINFO_EXTENSION);

				// @todo check for duplicate filename

				// try moving file
				if (!move_uploaded_file($this->request->data['Content'][$fieldName]['tmp_name'], $filename)) {
					return FALSE;

				// file successfully uploaded
				} else {
					// save the file path relative from WWW_ROOT e.g. uploads/example_filename.jpg
					$this->request->data['Content'][$fieldName] = str_replace(DS, "/", str_replace(WWW_ROOT, "", $filename) );
				}
			}
		} else {
			// set value to empty or existing value
			$this->request->data['Content'][$fieldName] = '';
		}

	}
/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {

		// gather list of available content pages
		$this->loadModel('Content');
		$contents = $this->Content->find('all');
		$contArr = array();
		foreach($contents as $page){
			$contArr[$page['Content']['id']] = $page['Content']['title'];
		}
		$this->set('contents',$contArr);

		// gather list of available vendors
		$this->loadModel('Vendor');
		$vendors = $this->Vendor->find('all');
		$vendArr = array();
		foreach($vendors as $vendor){
			$vendArr[$vendor['Vendor']['id']] = $vendor['Vendor']['name'];
		}
		$this->set('vendors',$vendArr);

		// load attributes for display
		$this->loadModel('ProductType');
		$prodTypes = $this->ProductType->find('all');
		// convert to array from objects
		$prodTypeArr = array();
		foreach($prodTypes as $val){
			$prodTypeArr[$val['ProductType']['id']] = $val['ProductType']['title'];
		}
		$this->set('productTypes',$prodTypeArr);

		if ($this->request->is('post')) {
			$this->uploadFile('pageImage');
			$this->uploadFile('csvFile');
			$this->Content->create();

			if ($this->Content->save($this->request->data)) {
				$this->Session->setFlash(__('The content has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The content could not be saved. Please, try again.'));
			}
		}
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Content->exists($id)) {
			throw new NotFoundException(__('Invalid content'));
		}
		if ($this->request->is(array('post', 'put'))) {
			
			// upload files if set
			$data = $this->Content->findById($id); 
			$this->uploadFile('pageImage');
			$this->uploadFile('csvFile');

			// overide blank values if existing values are found
			if($data['Content']['pageImage'])
			{
				$this->request->data['Content']['pageImage'] = $data['Content']['pageImage'];
			}
			if($data['Content']['csvFile'])
			{
				$this->request->data['Content']['csvFile'] = $data['Content']['csvFile'];
			}

			if ($this->Content->save($this->request->data)) {
				$this->Session->setFlash(__('The content has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The content could not be saved. Please, try again.'));
			}
		} else {

			// gather list of available content pages
			$this->loadModel('Content');
			$contents = $this->Content->find('all');
			$contArr = array();
			foreach($contents as $page){
				$contArr[$page['Content']['id']] = $page['Content']['title'];
			}
			$this->set('contents',$contArr);

			// gather list of available vendors
			$this->loadModel('Vendor');
			$vendors = $this->Vendor->find('all');
			$vendArr = array();
			foreach($vendors as $vendor){
				$vendArr[$vendor['Vendor']['id']] = $vendor['Vendor']['name'];
			}
			$this->set('vendors',$vendArr);

			// load attributes for display
			$this->loadModel('ProductType');
			$prodTypes = $this->ProductType->find('all');
			// convert to array from objects
			$prodTypeArr = array();
			foreach($prodTypes as $val){
				$prodTypeArr[$val['ProductType']['id']] = $val['ProductType']['title'];
			}
			$this->set('productTypes',$prodTypeArr);

			$options = array('conditions' => array('Content.' . $this->Content->primaryKey => $id));
			$this->request->data = $this->Content->find('first', $options);
		}
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->Content->id = $id;
		if (!$this->Content->exists()) {
			throw new NotFoundException(__('Invalid content'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Content->delete()) {

			// delete assigned products and attributes
			$this->loadModel('Product');
			$this->loadModel('ProductAttribute');

			$options = array('conditions' => array(
												'Product.contentId' => $id,
												));
			$products = $this->Product->find('all', $options);

			// delete all product attributes
			foreach($products as $product){
				$this->ProductAttribute->deleteAll(array('ProductAttribute.itemNumber' => $product['Product']['itemNumber']), false);
			}

			// delete all products
			$this->Product->deleteAll(array('Product.contentId' => $id), false);

			$this->Session->setFlash(__('The content has been deleted.'));
		} else {
			$this->Session->setFlash(__('The content could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

// front end tasks
// generate menu values from found pages
public function menu() {
    if (isset($this->params['requested']) && $this->params['requested'] == true) {
        $menus = $this->Content->find('all', array('order' => array('sortOrder Desc', 'title ASC') ));
        return $menus;
    } else {
        $this->set('menus', $this->Content->find('all', array('order' => array('sortOrder Desc', 'title ASC') )));
    }
}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Content->exists($id)) {
			throw new NotFoundException(__('Invalid content'));
		}
		$options = array('conditions' => array('Content.' . $this->Content->primaryKey => $id));
		$this->set('content', $this->Content->find('first', $options));
	}
}
