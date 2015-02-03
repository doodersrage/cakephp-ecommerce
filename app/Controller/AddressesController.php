<?php
App::uses('AppController', 'Controller');
/**
 * Addresses Controller
 *
 * @property Address $Address
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class AddressesController extends AppController {

	// states array for use within forms
	public $us_state_abbrevs_names = array(
			'AL'=>'ALABAMA',
			'AK'=>'ALASKA',
			'AS'=>'AMERICAN SAMOA',
			'AZ'=>'ARIZONA',
			'AR'=>'ARKANSAS',
			'CA'=>'CALIFORNIA',
			'CO'=>'COLORADO',
			'CT'=>'CONNECTICUT',
			'DE'=>'DELAWARE',
			'DC'=>'DISTRICT OF COLUMBIA',
			'FM'=>'FEDERATED STATES OF MICRONESIA',
			'FL'=>'FLORIDA',
			'GA'=>'GEORGIA',
			'GU'=>'GUAM GU',
			'HI'=>'HAWAII',
			'ID'=>'IDAHO',
			'IL'=>'ILLINOIS',
			'IN'=>'INDIANA',
			'IA'=>'IOWA',
			'KS'=>'KANSAS',
			'KY'=>'KENTUCKY',
			'LA'=>'LOUISIANA',
			'ME'=>'MAINE',
			'MH'=>'MARSHALL ISLANDS',
			'MD'=>'MARYLAND',
			'MA'=>'MASSACHUSETTS',
			'MI'=>'MICHIGAN',
			'MN'=>'MINNESOTA',
			'MS'=>'MISSISSIPPI',
			'MO'=>'MISSOURI',
			'MT'=>'MONTANA',
			'NE'=>'NEBRASKA',
			'NV'=>'NEVADA',
			'NH'=>'NEW HAMPSHIRE',
			'NJ'=>'NEW JERSEY',
			'NM'=>'NEW MEXICO',
			'NY'=>'NEW YORK',
			'NC'=>'NORTH CAROLINA',
			'ND'=>'NORTH DAKOTA',
			'MP'=>'NORTHERN MARIANA ISLANDS',
			'OH'=>'OHIO',
			'OK'=>'OKLAHOMA',
			'OR'=>'OREGON',
			'PW'=>'PALAU',
			'PA'=>'PENNSYLVANIA',
			'PR'=>'PUERTO RICO',
			'RI'=>'RHODE ISLAND',
			'SC'=>'SOUTH CAROLINA',
			'SD'=>'SOUTH DAKOTA',
			'TN'=>'TENNESSEE',
			'TX'=>'TEXAS',
			'UT'=>'UTAH',
			'VT'=>'VERMONT',
			'VI'=>'VIRGIN ISLANDS',
			'VA'=>'VIRGINIA',
			'WA'=>'WASHINGTON',
			'WV'=>'WEST VIRGINIA',
			'WI'=>'WISCONSIN',
			'WY'=>'WYOMING',
			'AE'=>'ARMED FORCES AFRICA \ CANADA \ EUROPE \ MIDDLE EAST',
			'AA'=>'ARMED FORCES AMERICA (EXCEPT CANADA)',
			'AP'=>'ARMED FORCES PACIFIC'
		);


	public function beforeFilter() {
        parent::beforeFilter();
        // Allow users to register and logout.
    	$this->Auth->deny('index');
		
		if ($this->Auth->user()){
			$this->Auth->allow('index', 'add', 'edit', 'billing', 'shipping');
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
		$this->Address->recursive = 0;
		$this->set('addresses', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Address->exists($id)) {
			throw new NotFoundException(__('Invalid address'));
		}
		$options = array('conditions' => array('Address.' . $this->Address->primaryKey => $id));
		$this->set('address', $this->Address->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Address->create();
			if ($this->Address->save($this->request->data)) {
				$this->Session->setFlash(__('The address has been saved.'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-warning'
			));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The address could not be saved. Please, try again.'), 'alert', array(
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
		if (!$this->Address->exists($id)) {
			throw new NotFoundException(__('Invalid address'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Address->save($this->request->data)) {
				$this->Session->setFlash(__('The address has been saved.'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-warning'
			));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The address could not be saved. Please, try again.'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-warning'
			));
			}
		} else {
			$options = array('conditions' => array('Address.' . $this->Address->primaryKey => $id));
			$this->request->data = $this->Address->find('first', $options);
		}
	}
	
	public function shipping() {
		
		// pass list of states
		$this->set('states',$this->us_state_abbrevs_names);
		
		// check for existing addres
		$options = array('conditions' => array(
											'Address.userId' => $this->Auth->user('id'),
											'Address.type' => 'ship',
											));
		$address = $this->Address->find('first', $options);
		
		// set initial post vals 
		if ($this->request->is('post')) {
			$this->request->data['Address']['type'] = 'ship';
			$this->request->data['Address']['userId'] = $this->Auth->user('id');
		}

		if (!$address) {
			if ($this->request->is('post')) {
				$this->Address->create();
				if ($this->Address->save($this->request->data)) {
					$this->Session->setFlash(__('The address has been saved.'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-warning'
			));
					return $this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('The address could not be saved. Please, try again.'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-warning'
			));
				}
			}
		} else {
			if ($this->request->is(array('post', 'put'))) {
				$this->request->data['id'] = $address['Address']['id'];
				if ($this->Address->save($this->request->data)) {
					$this->Session->setFlash(__('The address has been saved.'));
					return $this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('The address could not be saved. Please, try again.'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-warning'
			));
				}
			} else {
				$this->request->data = $address;
			}
		}
	}
	
	public function billing() {
		
		// pass list of states
		$this->set('states',$this->us_state_abbrevs_names);

		// check for existing addres
		$options = array('conditions' => array(
											'Address.userId' => $this->Auth->user('id'),
											'Address.type' => 'bill',
											));
		$address = $this->Address->find('first', $options);
		
		// set initial post vals 
		if ($this->request->is('post')) {
			$this->request->data['Address']['type'] = 'bill';
			$this->request->data['Address']['userId'] = $this->Auth->user('id');
		}

		if (!$address) {
			if ($this->request->is('post')) {
				$this->Address->create();
				if ($this->Address->save($this->request->data)) {
					$this->Session->setFlash(__('The address has been saved.'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-warning'
			));
					return $this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('The address could not be saved. Please, try again.'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-warning'
			));
				}
			}
		} else {
			if ($this->request->is(array('post', 'put'))) {
				$this->request->data['id'] = $address['Address']['id'];
				if ($this->Address->save($this->request->data)) {
					$this->Session->setFlash(__('The address has been saved.'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-warning'
			));
					return $this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('The address could not be saved. Please, try again.'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-warning'
			));
				}
			} else {
				$this->request->data = $address;
			}
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Address->id = $id;
		if (!$this->Address->exists()) {
			throw new NotFoundException(__('Invalid address'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Address->delete()) {
			$this->Session->setFlash(__('The address has been deleted.'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-warning'
			));
		} else {
			$this->Session->setFlash(__('The address could not be deleted. Please, try again.'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-warning'
			));
		}
		return $this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Address->recursive = 0;
		$this->set('addresses', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Address->exists($id)) {
			throw new NotFoundException(__('Invalid address'));
		}
		$options = array('conditions' => array('Address.' . $this->Address->primaryKey => $id));
		$this->set('address', $this->Address->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Address->create();
			if ($this->Address->save($this->request->data)) {
				$this->Session->setFlash(__('The address has been saved.'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-warning'
			));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The address could not be saved. Please, try again.'), 'alert', array(
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
		if (!$this->Address->exists($id)) {
			throw new NotFoundException(__('Invalid address'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Address->save($this->request->data)) {
				$this->Session->setFlash(__('The address has been saved.'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-warning'
			));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The address could not be saved. Please, try again.'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-warning'
			));
			}
		} else {
			$options = array('conditions' => array('Address.' . $this->Address->primaryKey => $id));
			$this->request->data = $this->Address->find('first', $options);
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
		$this->Address->id = $id;
		if (!$this->Address->exists()) {
			throw new NotFoundException(__('Invalid address'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Address->delete()) {
			$this->Session->setFlash(__('The address has been deleted.'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-warning'
			));
		} else {
			$this->Session->setFlash(__('The address could not be deleted. Please, try again.'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-warning'
			));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
