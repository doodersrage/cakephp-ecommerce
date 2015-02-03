<?php
App::uses('AppController', 'Controller');
/**
 * ProductAttributeTypes Controller
 *
 * @property ProductAttributeType $ProductAttributeType
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class ProductAttributeTypesController extends AppController {

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
		$this->ProductAttributeType->recursive = 0;
		$this->set('productAttributeTypes', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->ProductAttributeType->exists($id)) {
			throw new NotFoundException(__('Invalid product attribute type'));
		}
		$options = array('conditions' => array('ProductAttributeType.' . $this->ProductAttributeType->primaryKey => $id));
		$this->set('productAttributeType', $this->ProductAttributeType->find('first', $options));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->ProductAttributeType->recursive = 0;
		$this->set('productAttributeTypes', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->ProductAttributeType->exists($id)) {
			throw new NotFoundException(__('Invalid product attribute type'));
		}
		$options = array('conditions' => array('ProductAttributeType.' . $this->ProductAttributeType->primaryKey => $id));
		$this->set('productAttributeType', $this->ProductAttributeType->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->ProductAttributeType->create();
			if ($this->ProductAttributeType->save($this->request->data)) {
				$this->Session->setFlash(__('The product attribute type has been saved.'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-warning'
			));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The product attribute type could not be saved. Please, try again.'), 'alert', array(
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
		if (!$this->ProductAttributeType->exists($id)) {
			throw new NotFoundException(__('Invalid product attribute type'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->ProductAttributeType->save($this->request->data)) {
				$this->Session->setFlash(__('The product attribute type has been saved.'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-warning'
			));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The product attribute type could not be saved. Please, try again.'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-warning'
			));
			}
		} else {
			$options = array('conditions' => array('ProductAttributeType.' . $this->ProductAttributeType->primaryKey => $id));
			$this->request->data = $this->ProductAttributeType->find('first', $options);
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
		$this->ProductAttributeType->id = $id;
		if (!$this->ProductAttributeType->exists()) {
			throw new NotFoundException(__('Invalid product attribute type'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->ProductAttributeType->delete()) {
			$this->Session->setFlash(__('The product attribute type has been deleted.'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-warning'
			));
		} else {
			$this->Session->setFlash(__('The product attribute type could not be deleted. Please, try again.'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-warning'
			));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
