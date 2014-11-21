<?php
App::uses('AppController', 'Controller');
/**
 * ProductAttributes Controller
 *
 * @property ProductAttribute $ProductAttribute
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class ProductAttributesController extends AppController {

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
		$this->ProductAttribute->recursive = 0;
		$this->set('productAttributes', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->ProductAttribute->exists($id)) {
			throw new NotFoundException(__('Invalid product attribute'));
		}
		$options = array('conditions' => array('ProductAttribute.' . $this->ProductAttribute->primaryKey => $id));
		$this->set('productAttribute', $this->ProductAttribute->find('first', $options));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->ProductAttribute->recursive = 0;
		$this->set('productAttributes', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->ProductAttribute->exists($id)) {
			throw new NotFoundException(__('Invalid product attribute'));
		}
		$options = array('conditions' => array('ProductAttribute.' . $this->ProductAttribute->primaryKey => $id));
		$this->set('productAttribute', $this->ProductAttribute->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->ProductAttribute->create();
			if ($this->ProductAttribute->save($this->request->data)) {
				$this->Session->setFlash(__('The product attribute has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The product attribute could not be saved. Please, try again.'));
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
		if (!$this->ProductAttribute->exists($id)) {
			throw new NotFoundException(__('Invalid product attribute'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->ProductAttribute->save($this->request->data)) {
				$this->Session->setFlash(__('The product attribute has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The product attribute could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('ProductAttribute.' . $this->ProductAttribute->primaryKey => $id));
			$this->request->data = $this->ProductAttribute->find('first', $options);
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
		$this->ProductAttribute->id = $id;
		if (!$this->ProductAttribute->exists()) {
			throw new NotFoundException(__('Invalid product attribute'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->ProductAttribute->delete()) {
			$this->Session->setFlash(__('The product attribute has been deleted.'));
		} else {
			$this->Session->setFlash(__('The product attribute could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
