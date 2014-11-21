<?php
class AdminController extends AppController {

	public function index() {
		$this->redirect(array('controller' => 'admin/users', 'action' => 'login'));
	}

}