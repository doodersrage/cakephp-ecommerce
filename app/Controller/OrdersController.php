<?php
App::uses('AppController', 'Controller');
/**
 * Orders Controller
 *
 * @property Order $Order
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class OrdersController extends AppController {

	public function beforeFilter() {
        parent::beforeFilter();
				
		if ($this->Auth->user()){
			$this->Auth->allow('index','view','invoice');
		}
		
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
		$this->Order->recursive = 0;
		$this->Paginator->settings = array(
			'conditions' => array('Order.userId' => $this->Auth->user('id')),
			'limit' => 10,
				'order' => array(
					'Order.dateOrdered' => 'desc'
				)
		);
		$this->set('orders', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Order->exists($id)) {
			throw new NotFoundException(__('Invalid order'));
		}
		$options = array('conditions' => array('Order.' . $this->Order->primaryKey => $id, 'Order.userId'=>$this->Auth->user('id')));
		$this->set('order', $this->Order->find('first', $options));
	}
	public function invoice($id = null) {
		// disable layout and view
		$this->layout = 'blank';
		
		if (!$this->Order->exists($id)) {
			throw new NotFoundException(__('Invalid order'));
		}
		$options = array('conditions' => array('Order.' . $this->Order->primaryKey => $id, 'Order.userId'=>$this->Auth->user('id')));
		$this->set('order', $this->Order->find('first', $options));
	}
	public function admin_invoice($id = null) {
		// disable layout and view
		$this->layout = 'blank';
		
		if (!$this->Order->exists($id)) {
			throw new NotFoundException(__('Invalid order'));
		}
		$options = array('conditions' => array('Order.' . $this->Order->primaryKey => $id));
		$this->set('order', $this->Order->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Order->create();
			if ($this->Order->save($this->request->data)) {
				$this->Session->setFlash(__('The order has been saved.'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-warning'
			));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The order could not be saved. Please, try again.'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-warning'
			));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Order->exists($id)) {
			throw new NotFoundException(__('Invalid order'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Order->save($this->request->data)) {
				$this->Session->setFlash(__('The order has been saved.'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-warning'
			));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The order could not be saved. Please, try again.'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-warning'
			));
			}
		} else {
			$options = array('conditions' => array('Order.' . $this->Order->primaryKey => $id));
			$this->request->data = $this->Order->find('first', $options);
		}
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Order->recursive = 0;
		$this->Paginator->settings = array(
			'limit' => 10,
				'order' => array(
					'Order.dateOrdered' => 'desc'
				)
		);
		$this->set('orders', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Order->exists($id)) {
			throw new NotFoundException(__('Invalid order'));
		}
		// load existing order data
		$options = array('conditions' => array('Order.' . $this->Order->primaryKey => $id));
		$order = $this->Order->find('first', $options);
		
		// update existing order data on submission
		if ($this->request->is('post')) {
			// test submitted order data
			//print_r($this->request->data);
			
			// load order products
			$products = unserialize($order['Order']['products']);
				
			// update ship and freight charges
			$shipping = unserialize($order['Order']['shipping']);
			
			$shipTotal = 0;
			// walk through all order products
			foreach($products as $idx => $val){
				
				// update or assign ship dates
				$shipping[$idx]['shipDate'] = $this->request->data['shipDate'][preg_replace('/[^a-z0-9]+/i', '_', $idx)];
				
				// update or assign ship charge
				$shipCost = $this->request->data['shipping'][preg_replace('/[^a-z0-9]+/i', '_', $idx)];
				$shipping[$idx]['selShipCost'] = $shipCost;
				$shipTotal += $shipCost;
								
			}
			
			// update total shipping charge
			$shipping['total'] = $shipTotal;
			
			$order['Order']['shipping'] = serialize($shipping);
			
			// update order total based on shipping costs
			$order['Order']['total'] = $order['Order']['subTotal'] + $shipTotal;
			
			// set order specific values
			$order['Order']['notes'] = $this->request->data['notes'];
			$order['Order']['status'] = $this->request->data['status'];
			
			// save updated order data
			$this->Order->save($order);
			
			// notify customer if selected
			if($this->request->data['notifyCustomer'] === 1){
				$billing = unserialize($order['Order']['billAddress']);

				// send out order emails
				App::uses('CakeEmail', 'Network/Email');
											
				$Email = new CakeEmail();
				$Email->template('invoice', 'default');
				$Email->viewVars(array('order' => $order));
				$Email->to($billing['email']);
				$Email->emailFormat('html');
				$Email->subject('CGS Order Update');
				$Email->replyTo('noreply@cgs.com');
				$Email->from ('noreply@cgs.com');
				$Email->send();

			}
			
		}
		
		$this->set('order', $order);
}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Order->exists($id)) {
			throw new NotFoundException(__('Invalid order'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Order->save($this->request->data)) {
				$this->Session->setFlash(__('The order has been saved.'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-warning'
			));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The order could not be saved. Please, try again.'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-warning'
			));
			}
		} else {
			$options = array('conditions' => array('Order.' . $this->Order->primaryKey => $id));
			$this->request->data = $this->Order->find('first', $options);
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
		$this->Order->id = $id;
		if (!$this->Order->exists()) {
			throw new NotFoundException(__('Invalid order'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Order->delete()) {
			$this->Session->setFlash(__('The order has been deleted.'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-warning'
			));
		} else {
			$this->Session->setFlash(__('The order could not be deleted. Please, try again.'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-warning'
			));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
