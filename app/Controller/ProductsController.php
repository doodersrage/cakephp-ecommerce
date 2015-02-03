<?php
App::uses('AppController', 'Controller');
/**
 * Products Controller
 *
 * @property Product $Product
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class ProductsController extends AppController {

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
		$this->Product->recursive = 0;
		$this->set('products', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Product->exists($id)) {
			throw new NotFoundException(__('Invalid product'));
		}
		$options = array('conditions' => array('Product.' . $this->Product->primaryKey => $id));
		$this->set('product', $this->Product->find('first', $options));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Product->recursive = 0;
		$this->set('products', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Product->exists($id)) {
			throw new NotFoundException(__('Invalid product'));
		}
		$options = array('conditions' => array('Product.' . $this->Product->primaryKey => $id));
		$selProduct = $this->Product->find('first', $options);
		$this->set('product', $selProduct);

		// gather assigned product attributes
		$this->loadModel('ProductAttribute');

		$options = array('conditions' => array(
											'ProductAttribute.itemNumber' => $selProduct['Product']['itemNumber'],
											));
		$attributes = $this->ProductAttribute->find('all', $options);

		$this->set('attributes',$attributes);

		// gather attribute type data
		$this->loadModel('ProductAttributeType');

		// gather all values
		$attributeTypes = $this->ProductAttributeType->find('all');

		// convert to single dimensional array
		$attrTypesArr = array();
		foreach($attributeTypes as $attributeType){
			$attrTypesArr[$attributeType['ProductAttributeType']['id']] = $attributeType['ProductAttributeType']['title'];
		}

		$this->set('attributeTypes',$attrTypesArr);

		// gather assigned product attributes
		$this->loadModel('ProductType');

		$options = array('conditions' => array(
											'ProductType.id' => $selProduct['Product']['prodType'],
											));
		$productType = $this->ProductType->find('first', $options);

		$this->set('productType',$productType);

	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		// load attributes for display
		$this->loadModel('ProductType');
		$prodTypes = $this->ProductType->find('all');

		// convert to array from objects
		$prodTypeArr = array();
		foreach($prodTypes as $val){
			$prodTypeArr[$val['ProductType']['id']] = $val['ProductType']['title'];
		}

		// gather list of available content pages
		$this->loadModel('Content');
		$contents = $this->Content->find('all');
		$contArr = array();
		foreach($contents as $page){
			$contArr[$page['Content']['id']] = $page['Content']['title'];
		}
		$this->set('contents',$contArr);

		// save to view accessible variable
		$this->set('productTypes',$prodTypeArr);

		if ($this->request->is('post')) {
			$this->Product->create();
			if ($this->Product->save($this->request->data)) {

				// save product attribute values
				$this->loadModel('ProductAttribute');
				$productAttrs = $this->request->data('attribute');

				foreach($productAttrs as $idx => $productAttr){
					// gather selected attribute data
                	$attributeVal = trim($productAttr);

        			// save attribute to database
        			$options = array('conditions' => array(
    													'ProductAttribute.attributeId' => $idx, 
    													'ProductAttribute.itemNumber' => $this->request->data('Product.itemNumber'),
    													));
					$attribute = $this->ProductAttribute->find('first', $options);
					if(!$attribute){
	        			$this->ProductAttribute->create();
	            	} else {
	            		$this->ProductAttribute->id = $this->request->data('Product.itemNumber');
	            	}
	                $this->ProductAttribute->save(
	                    array(
                        	'attributeId' => $idx,
                        	'itemNumber' => $this->request->data('Product.itemNumber'),
                        	'content' => $attributeVal,
	                    )
	                );
	                $this->ProductAttribute->clear();

				}

				$this->Session->setFlash(__('The product has been saved.'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-warning'
			));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The product could not be saved. Please, try again.'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-warning'
			));
			}
		}
	}

	// used to enable attribute options for new products
	public function admin_product_attributes_ajax(){
		// set ajax layout
		$this->layout='ajax';

		// gather selected product type id
		$id = $this->request->data('id');

		// gather attribute type data
		$this->loadModel('ProductAttributeType');

		// gather all values
		$attributeTypes = $this->ProductAttributeType->find('all');

		// convert to single dimensional array
		$attrTypesArr = array();
		foreach($attributeTypes as $attributeType){
			$attrTypesArr[$attributeType['ProductAttributeType']['id']] = $attributeType['ProductAttributeType']['title'];
		}

		$this->set('attributeTypes',$attrTypesArr);

		// gather assigned product attributes
		$this->loadModel('ProductType');

		$options = array('conditions' => array(
											'ProductType.id' => $id = $this->request->data('id'),
											));
		$productType = $this->ProductType->find('first', $options);

		$this->set('productType',$productType);

	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Product->exists($id)) {
			throw new NotFoundException(__('Invalid product'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Product->save($this->request->data)) {

				// save product attribute values
				$this->loadModel('ProductAttribute');
				$productAttrs = $this->request->data('attribute');

				foreach($productAttrs as $idx => $productAttr){
					// gather selected attribute data
                	$attributeVal = trim($productAttr);

        			// save attribute to database
        			$options = array('conditions' => array(
    													'ProductAttribute.attributeId' => $idx, 
    													'ProductAttribute.itemNumber' => $id,
    													));
					$attribute = $this->ProductAttribute->find('first', $options);
					if(!$attribute){
	        			$this->ProductAttribute->create();
	            	} else {
	            		$this->ProductAttribute->id = $idx;
	            	}
	                $this->ProductAttribute->save(
	                    array(
                        	'attributeId' => $idx,
                        	'itemNumber' => $id,
                        	'content' => $attributeVal,
	                    )
	                );
	                $this->ProductAttribute->clear();

				}

				$this->Session->setFlash(__('The product has been saved.'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-warning'
			));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The product could not be saved. Please, try again.'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-warning'
			));
			}
		} else {
			$options = array('conditions' => array('Product.' . $this->Product->primaryKey => $id));
			$selProduct = $this->Product->find('first', $options);
			$this->request->data = $selProduct;

			// gather assigned product attributes
			$this->loadModel('ProductAttribute');

			$options = array('conditions' => array(
												'ProductAttribute.itemNumber' => $selProduct['Product']['itemNumber'],
												));
			$attributes = $this->ProductAttribute->find('all', $options);

			$this->set('attributes',$attributes);

			// gather attribute type data
			$this->loadModel('ProductAttributeType');

			// gather all values
			$attributeTypes = $this->ProductAttributeType->find('all');

			// convert to single dimensional array
			$attrTypesArr = array();
			foreach($attributeTypes as $attributeType){
				$attrTypesArr[$attributeType['ProductAttributeType']['id']] = $attributeType['ProductAttributeType']['title'];
			}

			$this->set('attributeTypes',$attrTypesArr);

			// load attributes for display
			$this->loadModel('ProductType');
			$prodTypes = $this->ProductType->find('all');

			// convert to array from objects
			$prodTypeArr = array();
			foreach($prodTypes as $val){
				$prodTypeArr[$val['ProductType']['id']] = $val['ProductType']['title'];
			}

			// gather list of available content pages
			$this->loadModel('Content');
			$contents = $this->Content->find('all');
			$contArr = array();
			foreach($contents as $page){
				$contArr[$page['Content']['id']] = $page['Content']['title'];
			}
			$this->set('contents',$contArr);

			// save to view accessible variable
			$this->set('productTypes',$prodTypeArr);

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
		$this->Product->id = $id;
		if (!$this->Product->exists()) {
			throw new NotFoundException(__('Invalid product'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Product->delete()) {

			// delete assigned product attributes
			$this->loadModel('ProductAttribute');

			$this->ProductAttribute->deleteAll(array('ProductAttribute.itemNumber' => $id), false);

			$this->Session->setFlash(__('The product has been deleted.'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-warning'
			));
		} else {
			$this->Session->setFlash(__('The product could not be deleted. Please, try again.'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-warning'
			));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
