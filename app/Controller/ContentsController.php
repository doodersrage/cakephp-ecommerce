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
            'editor' => 'Tinymce',
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
				if(is_numeric($path[0])){

					if (!$this->Content->exists($path[0])) {
						throw new NotFoundException(__('Invalid content'));
					}
					$options = array('conditions' => array('Content.' . $this->Content->primaryKey => $path[0]));
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
					
				// if home page change to static home page view
				if($path[0] == 'home'){
					$this->set('jsIncludes',array('home'));  
					$this->render('home');
				}
				
				// send email on contact form submission
				if ($this->request->is('post') && isset($this->request->data['Contact']['message'])) {
					if(!empty($this->request->data['Contact']['message']) && !empty($this->request->data['Contact']['name']) && !empty($this->request->data['Contact']['email'])){
				
					// send out order emails
					App::uses('CakeEmail', 'Network/Email');
												
					$Email = new CakeEmail();
					$Email->template('contact', 'default');
					$Email->viewVars(array(
						'email' => $this->request->data['Contact']['email'],
						'name' => $this->request->data['Contact']['name'],
						'message' => $this->request->data['Contact']['message'],
					));
					$Email->to('ralston@coresix.com','rob@studiocenter.com');
					$Email->emailFormat('html');
					$Email->subject('CGS Contact Form Submission');
					$Email->replyTo($this->request->data['Contact']['email']);
					$Email->from ($this->request->data['Contact']['email']);
					$Email->send();
					
					} else {
						$this->Session->setFlash(__('Name, email, or message fields are not populated. Please fill out all required fields!'), 'alert', array(
							'plugin' => 'BoostCake',
							'class' => 'alert-warning'
						));
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
		$options = array('conditions' => array('Product.contentId' => $idx), 'limit' => 20,'order' => array('Product.sort' => 'asc'),);
		$this->Paginator->settings = $options;
		$products = $this->Paginator->paginate('Product');

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
	
	// delete all selected products
	public function delete_products($id = null){
		
        // load needed data models
		$this->loadModel('ProductAttribute');
		$this->loadModel('ProductAttributeType');
		$this->loadModel('ProductType');
		$this->loadModel('Product');
		
		// load content data
		$options = array('conditions' => array('Content.' . $this->Content->primaryKey => $id));
		$content = $this->Content->find('first', $options);

		$options = array('conditions' => array(
											'Product.contentId' => $id,
											'Product.prodType' => $content['Content']['productListType'],
											));
		$products = $this->Product->find('all', $options);

		// delete all product attributes
		foreach($products as $product){
			$this->ProductAttribute->deleteAll(array('ProductAttribute.itemNumber' => $product['Product']['itemNumber']), false);
		}
		
		// delete all products assigned to content
		$this->Product->deleteAll(array('Product.contentId' => $id), false);

	}
	
	// AJAX call to delete all products from page
	public function admin_delete_products($id = null){
		// disable layout and view
		$this->autoRender = false;
		
		// gather selected content id
		$id = $this->request->data('id');
		
		// check for existing content
		if (!$this->Content->exists($id)) {
			throw new NotFoundException(__('Invalid content'));
		}
		
		// delete products
		$this->delete_products($id);
		
		echo 'Products deleted!';
	}
	
	// AJAX call for importing products through assigned CSV
	public function admin_import_products($id = null){
		ini_set('auto_detect_line_endings', true);
		// disable layout and view
		$this->autoRender = false;

        // load needed data models
		$this->loadModel('ProductAttribute');
		$this->loadModel('ProductAttributeType');
		$this->loadModel('ProductType');
		$this->loadModel('Product');
		
		// gather selected content id
		$id = $this->request->data('id');

		// delete existing products value
		$replProds = $this->request->data('replProds');

		// check for existing content
		if (!$this->Content->exists($id)) {
			throw new NotFoundException(__('Invalid content'));
		}
		
		// delete current products if selected
		if($replProds == true){
			// delete products
			$this->delete_products($id);
		}

		// load content data
		$options = array('conditions' => array('Content.' . $this->Content->primaryKey => $id));
		$content = $this->Content->find('first', $options);
		
		// check for column in attributes
		$prodType = $this->ProductType->find('first', array(
			'conditions' => array('ProductType.id' => $content['Content']['productListType'] )
		));
		
		// gather available price tiers
		$tieredPricing = unserialize($prodType['ProductType']['tieredPricing']);

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
		
		// assign static column names to array
		$staticColumns = array('Item Number','Quantity','Price Each','Min Quantity','Full Length','Full Width','Ship QTY Inc','Ship Inc Cost');
       
        // read each data row in the file
        $i = 0;
		$skipped = 0;
        $attrTypesArr = array();
		$staticTypesArr = array();
		$priceClms = array();
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
						continue;
				    }
					
					// check for static columns
					foreach($staticColumns as $sid => $staticColumn){
						if(strtoupper(trim($staticColumn)) == strtoupper(trim($clm))){
							$staticTypesArr[$staticColumn] = array(trim($sid), $idx);
						}
					}
					
					// check for assigned pricing tiers then gather data from submitted CSV
					if(!empty($tieredPricing)){
						// iterate through assigned tiered pricing
						foreach($tieredPricing as $tpidx => $price){
							// store found columns
							if(strtoupper($price[1]) != '' && strtoupper($price[1]) == strtoupper(trim($clm))){
								$priceClms[$idx] = array(trim($clm),$tpidx,$price[0]);
							}
						}
					}
				}
        	} else {						
				
				// store non-attribute data for easy access
				// if any one of the three values are not assigned for a single product skip inserting entire product
				if(isset($staticTypesArr['Item Number'])){
					$itemNumber = $row[$staticTypesArr['Item Number'][1]];
				} else {
					++$skipped;
					continue;
				}
				if(isset($staticTypesArr['Quantity'])){
					$quantity = $row[$staticTypesArr['Quantity'][1]];
				} else {
					$quantity = 0;
				}
				if(isset($staticTypesArr['Price Each'])){
					$priceEach = floatval(preg_replace('/[^\d\.]/', '', $row[$staticTypesArr['Price Each'][1]]));
				} else {
					++$skipped;
					continue;
				}
				
				$newProduct = array(
									'itemNumber' => $itemNumber,
									'price' => $priceEach,
									'quantity' => $quantity,
									'prodType' => $content['Content']['productListType'],
									'contentId' => $content['Content']['id'],
								);
				
				// add other static property values
				if(isset($staticTypesArr['Min Quantity'])){
					$newProduct['minQty'] = $row[$staticTypesArr['Min Quantity'][1]];
				}
				
				// add other static property values
				if(isset($staticTypesArr['Full Length'])){
					$newProduct['fullLength'] = $row[$staticTypesArr['Full Length'][1]];
				}

				// add other static property values
				if(isset($staticTypesArr['Full Width'])){
					$newProduct['fullWidth'] = $row[$staticTypesArr['Full Width'][1]];
				}

				// add other static property values
				if(isset($staticTypesArr['Ship QTY Inc'])){
					$newProduct['shipIncQty'] = $row[$staticTypesArr['Ship QTY Inc'][1]];
				}

				// add other static property values
				if(isset($staticTypesArr['Ship Inc Cost'])){
					$newProduct['shipIncCost'] = $row[$staticTypesArr['Ship Inc Cost'][1]];
				}
				
				// check for assigned pricing tiers then gather data from submitted CSV
				$priceClmsData = array();
				if(count($priceClms) > 0){
					foreach($priceClms as $idx => $price){
					  	if(!empty($row[$idx])){
							$priceClmsData[$price[2]] = floatval(preg_replace('/[^\d\.]/', '', trim($row[$idx])));
						}
					}
					$newProduct['tieredPricing'] = serialize($priceClmsData);
				}

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
				$this->Product->save($newProduct);
				$this->Product->clear();
				
				//$log = $this->Product->getDataSource()->getLog(false, false);
				//print_r($log);

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

        	}

        	++$i;
        }

        fclose($handle);

        echo $csvLineCnt.' Lines read and products imported! '.$skipped.' products skipped!';

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
		$this->menu();
		$this->gen_mnu_opts();
		$this->set('contents',$this->navOpts);

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
				$this->Session->setFlash(__('The content has been saved.'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-warning'
			));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The content could not be saved. Please, try again.'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-warning'
			));
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
			if($this->request->data('delImage')  != 1){
				if($data['Content']['pageImage'] && empty($this->request->data['Content']['pageImage']['tmp_name']))
				{
					$this->request->data['Content']['pageImage'] = $data['Content']['pageImage'];
				}
			} else {
				// delete image from filesystem
				$filename = WWW_ROOT . $this->uploadDir . DS . $data['Content']['pageImage'];
				unlink($filename);
			}
			if($this->request->data('delCSV')  != 1){
				if($data['Content']['csvFile'] && empty($this->request->data['Content']['csvFile']['tmp_name']))
				{
					$this->request->data['Content']['csvFile'] = $data['Content']['csvFile'];
				}
			} else {
				// delete image from filesystem
				$filename = WWW_ROOT . $this->uploadDir . DS . $data['Content']['csvFile'];
				unlink($filename);
				// delete products
				$this->delete_products($id);
			}

			if ($this->Content->save($this->request->data)) {
				$this->Session->setFlash(__('The content has been saved.'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-warning'
			));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The content could not be saved. Please, try again.'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-warning'
			));
			}
		} else {
			
			// generate menu selection
			$this->menu();
			$this->gen_mnu_opts();
			$this->set('contents',$this->navOpts);

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
	
	// gather page options
	public $navOpts;
	private function gen_mnu_opts(){
		foreach($this->topNav as $idx => $mItm){
			if(isset($mItm['Content'])){
				$this->navOpts[$mItm['Content']['id']] = $mItm['Content']['title'];
				$this->gen_mnu_child_opts($idx);
			}
		}

	}
	private function gen_mnu_child_opts($idx,$sep = '-'){
		if(isset($this->topNav[$idx]['children'])){
			$sep = $sep . '-';
			foreach($this->topNav[$idx]['children'] as $mItm){
				$this->navOpts[$mItm['Content']['id']] = $sep.' '.$mItm['Content']['title'];
				$this->gen_mnu_child_opts($mItm['Content']['id'],$sep);
			}
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

			// delete products
			$this->delete_products($id);

			$this->Session->setFlash(__('The content has been deleted.'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-warning'
			));
		} else {
			$this->Session->setFlash(__('The content could not be deleted. Please, try again.'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-warning'
			));
		}
		return $this->redirect(array('action' => 'index'));
	}
	
	// front end tasks
	// generate menu values from found pages
	public $topNav;
	public function menu() {
			$contents = $this->Content->find('all', array('conditions' => array('Content.parentId' => 0), 'order' => array('sortOrder Desc', 'title ASC') ));
			
			// discover child pages
			foreach($contents as $content){
				$this->topNav[$content['Content']['id']] = $content;
				$this->gatherPageLinks($content['Content']['id']);
			}
	
			return $menus = $this->topNav;
	}
	
	private function gatherPageLinks($parentId){
		$contents = $this->Content->find('all', array('conditions' => array('Content.parentId' => $parentId), 'order' => array('sortOrder Desc', 'title ASC') ));
		
		// save found child pages
		if($contents){
			$this->topNav[$parentId]['children'] = $contents;
			// walk through children checking for more
			foreach($contents as $content){
				$this->gatherPageLinks($content['Content']['id']);
			}
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
