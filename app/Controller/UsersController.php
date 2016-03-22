<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 */
class UsersController extends AppController {

/**
 * Scaffold
 *
 * @var mixed
 */

	public function beforeFilter() {
        parent::beforeFilter();
        // Allow users to register and logout.
    	$this->Auth->allow('add', 'logout', 'thanks','forgetpassword');
		
		if ($this->Auth->user()){
			$this->Auth->allow('edit');
		}
		
    }

    public function login() {

        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                return $this->redirect($this->Auth->redirect());
            } 
            $this->Session->setFlash(__('Invalid username or password, try again'), 'alert', array(
                'plugin' => 'BoostCake',
                'class' => 'alert-warning'
            ));
        }
    }

    public function admin_login() {
        $u = $this->Auth->user();
        //echo $u['role'];
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                return $this->redirect($this->Auth->redirectUrl());
            } 
            $this->Session->setFlash(__('Invalid username or password, try again'), 'alert', array(
                'plugin' => 'BoostCake',
                'class' => 'alert-warning'
            ));
        }
    }

    public function logout() {
        return $this->redirect($this->Auth->logout());
    }

    public function admin_logout() {
        return $this->redirect($this->Auth->logout());
    }


    public function index() {
        $this->User->recursive = 0;
        $this->set('users', $this->paginate());
    }

    public function admin_index() {
        $this->User->recursive = 0;
        $this->set('users', $this->paginate());
    }

    public function view($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->set('user', $this->User->read(null, $id));
    }

    public function add() {
        if ($this->request->is('post')) {
			
			// check for existing user before saving
			$conditions = array(
				'User.email' => $this->request->data['User']['email'],
				'User.username' => $this->request->data['User']['username'],
			);
			// create user if user has not been found
			if (!$this->User->hasAny($conditions)){
				
				$this->User->create();
				if ($this->User->save($this->request->data)) {
					$this->Session->setFlash(__('The user has been saved'), 'alert', array(
						'plugin' => 'BoostCake',
						'class' => 'alert-warning'
					));
		
					// send out new user emails
					App::uses('CakeEmail', 'Network/Email');
												
					$Email = new CakeEmail();
					$Email->template('thanks', 'default');
					$Email->viewVars(array(
										'email' => $this->request->data['User']['email'],
										'username' => $this->request->data['User']['username'],
										'password' => $this->request->data['User']['password'],
										));
					$Email->to($this->request->data['User']['email']);
					$Email->emailFormat('html');
					$Email->subject('CGO Account Signup');
					$Email->replyTo('sales@customglassandoptics.com');
					$Email->from ('sales@customglassandoptics.com');
					$Email->send();
	
					return $this->redirect(array('action' => 'thanks'));
				}
				
			}
            $this->Session->setFlash(
                __('The user could not be saved. Please, try again.'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-warning'
			));
        }
    }
	
	// user thanks on account creation
	public function thanks(){
	}

    public function admin_add() {
        if ($this->request->is('post')) {
            $this->User->create();
			// check for existing user before saving
			$conditions = array(
				'User.email' => $this->request->data['User']['email'],
				'User.username' => $this->request->data['User']['username'],
			);
			// create user if user has not been found
			if (!$this->User->hasAny($conditions)){
					
				if ($this->User->save($this->request->data)) {
		
					// send out new user emails
					App::uses('CakeEmail', 'Network/Email');
												
					$Email = new CakeEmail();
					$Email->template('thanks', 'default');
					$Email->viewVars(array(
										'email' => $this->request->data['User']['email'],
										'username' => $this->request->data['User']['username'],
										'password' => $this->request->data['User']['password'],
										));
					$Email->to($this->request->data['User']['email']);
					$Email->emailFormat('html');
					$Email->subject('CGO Account Signup');
					$Email->replyTo('sales@customglassandoptics.com');
					$Email->from ('sales@customglassandoptics.com');
					$Email->send();

					$this->Session->setFlash(__('The user has been saved'), 'alert', array(
						'plugin' => 'BoostCake',
						'class' => 'alert-warning'
					));
					return $this->redirect(array('action' => 'index'));
				}
				
			}
            $this->Session->setFlash(
                __('The user could not be saved. Please, try again.'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-warning'
			));
        }
    }

    public function edit($id = null) {
        $this->User->id = $id;
		// ensure selected user is authenticated user
		$userData = $this->Auth->user();
		if($this->User->id !== $userData['id']){
            throw new NotFoundException(__('User not authorize'));
		}
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'), 'alert', array(
					'plugin' => 'BoostCake',
					'class' => 'alert-warning'
				));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash(
                __('The user could not be saved. Please, try again.'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-warning'
			));
        } else {
            $this->request->data = $this->User->read(null, $id);
            unset($this->request->data['User']['password']);
        }
    }
	
	private function randomPassword() {
		$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
		$pass = array(); //remember to declare $pass as an array
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		for ($i = 0; $i < 8; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass); //turn the array into a string
	}

    public function forgetpassword($id = null) {

        if ($this->request->is('post') || $this->request->is('put')) {
			
			$options = array('conditions' => array(
											'User.username' => $this->request->data['User']['username'], 
											'User.email'=>$this->request->data['User']['email']
											));
											
			$user = $this->User->find('first', $options);
			
			if($user){
				// gen random password
				$newPass = $this->randomPassword();
	
				$user['User']['password'] = $newPass;
				
				// send out order emails
				App::uses('CakeEmail', 'Network/Email');
											
				$Email = new CakeEmail();
				$Email->template('password', 'default');
				$Email->viewVars(array(
									'password' => $newPass,
									));
				$Email->to($this->request->data['User']['email']);
				$Email->emailFormat('html');
				$Email->subject('CGO Account Password Reset');
				$Email->replyTo('sales@customglassandoptics.com');
				$Email->from ('sales@customglassandoptics.com');
				$Email->send();
			
				if ($user) {
					$this->Session->setFlash(__('The user has been saved'));
					return $this->redirect(array('action' => 'index'));
				}
			}
            $this->Session->setFlash(
                __('The user could not be saved. Please, try again.'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-warning'
			));
        } else {
            $this->request->data = $this->User->read(null, $id);
        }
    }

    public function admin_edit($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash(
                __('The user could not be saved. Please, try again.'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-warning'
			));
        } else {
            $this->request->data = $this->User->read(null, $id);
            unset($this->request->data['User']['password']);
        }
    }

    public function delete($id = null) {
        // Prior to 2.5 use
        // $this->request->onlyAllow('post');

        $this->request->allowMethod('post');

        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->User->delete()) {
            $this->Session->setFlash(__('User deleted'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-warning'
			));
            return $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('User was not deleted'), 'alert', array(
				'plugin' => 'BoostCake',
				'class' => 'alert-warning'
			));
        return $this->redirect(array('action' => 'index'));
    }

}
