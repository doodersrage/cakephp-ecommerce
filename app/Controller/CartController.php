<?php
App::uses('CakeNumber', 'Utility');

class CartController extends AppController {

	// load class components
	public $components = array('AuthorizeNet', 'Session');

	public function beforeFilter() {
		// ensure parent class before filter is callled
		parent::beforeFilter();

		// assign admin layout for admin users
		if (isset($this->params['prefix']) && $this->params['prefix'] == 'admin') {
	        $this->layout = 'admin';
	    }
	    // allow default access to actions
	    $this->Auth->allow('index','add','get','delete','checkout','confirm');
	}

	public function index() {

		// gather user cart
		$userCart = $this->Session->read('User.Cart');

		// gather product prices and totals
		$prices = $this->calcPrices();

		// assign values for the cart view
		$this->set('prices',$prices[0]);
		$this->set('subTotal',$prices[1]);
		$this->set('shipping',$prices[2]);
		$this->set('cart',$userCart);

	}

	// show order confirmation to user
	public function confirm() {

		// load required models for display
		$this->loadModel('Order');

		// clear user session variables
		$this->Session->delete('User.Cart');
		$this->Session->delete('User.Prices');
		$this->Session->delete('User.Address');
		$this->Session->delete('User.ShipAddress');

		// get most recent customer order
		$options = array('conditions' => array('Order.id'=>$this->request->query['o']),
							'limit' => 1,
							'order' => array(
								'Order.dateOrdered' => 'desc'
							)
						);
		$this->set('order', $this->Order->find('first', $options));
	}

	// determine total cost of users items in cart
	private function calcPrices(){
		$this->loadModel('ProductType');
		$this->loadModel('Product');

		// gather user cart
		$userCart = $this->Session->read('User.Cart');

		// gather product prices and totals
		// this is done to prevent front end price jacking via JavaScript
		$prices = array();
		$subTotal = 0;
		if(isset($userCart)){

			foreach($userCart as $idx => $val){

				// gather product data
				$options = array('conditions' => array('Product.itemNumber' => $idx));
				$product = $this->Product->find('first', $options);

				// gather product type data
				$options = array('conditions' => array('ProductType.id' => $product['Product']['prodType']));
				$productType = $this->ProductType->find('first', $options);

				// set product default pricing
				$prices[$idx] = $product['Product']['price'];

				// check for tiered pricing
				$tieredLevels = unserialize($productType['ProductType']['tieredPricing']);
				if(!empty($tieredLevels)){
					$prodTieredPrices = unserialize($product['Product']['tieredPricing']);
					if(!empty($prodTieredPrices)){
						foreach($tieredLevels as $tidx => $tval){
							if($val['qty'] >= $tval[0]){
								$prices[$idx] = $prodTieredPrices[$tval[0]];
							}
						}
					}
				}

				// calc shipping
				$shipArr = array();
				if(!empty($product['Product']['shipIncQty']) && !empty($product['Product']['shipIncCost'])){
					$shipArr[$idx]['selShipQty'] = ceil(($val['qty']/$product['Product']['shipIncQty']));
					$shipArr[$idx]['selShipCost'] = $selShipQty * $product['Product']['shipIncCost'];
					$shipArr['total'] = CakeNumber::precision($shipArr['total'] + $shipArr[$idx]['selShipCost'], 2);
				}

				// determine dimensional charges
				// square
				if(!empty($val['length']) && !empty($val['width'])){
					$dimVal = $val['length'] * $val['width'];
				// linear
				} elseif(!empty($val['length'])){
					$dimVal = $val['length'];
				} else {
					$dimVal = 1;
				}

				// update price based on selected measurement
				if($productType['ProductType']['dimensionMeasurement'] === 'in' && $productType['ProductType']['dimensionType'] === 'square'){
					$prices[$idx] /= 144;
				} else if($productType['ProductType']['dimensionMeasurement'] === 'in' && $productType['ProductType']['dimensionType'] === 'linear'){
					$prices[$idx] /= 12;
				}

				// calculate total price
				$prices[$idx] = CakeNumber::precision($prices[$idx] * $dimVal * $val['qty'], 2);
				$subTotal += $prices[$idx];
			}

			// store calculated price values for remaining checkout pages
			$this->Session->write('User.Prices', $prices);
		}

		return array($prices, CakeNumber::precision($subTotal, 2), (isset($shipArr) ? $shipArr : ''));
	}

	// get existing product data
	public function get(){
		// disable layout and view
		$this->autoRender = false;

		// load existing cart to add/edit products
		$curCart = $this->Session->read('User.Cart');

		echo json_encode($curCart);
		exit;
	}

	// checkout action
	public function checkout(){
		// load associates models
		$this->loadModel('User');
		$this->loadModel('Order');
		$this->loadModel('ProductType');
		$this->loadModel('Product');
		$this->loadModel('Address');

		// gather user cart
		$userCart = $this->Session->read('User.Cart');

		// gather product prices and totals
		$prices = $this->calcPrices();

		// determin order total
		$orderTotal = ($prices[1]+(!empty($prices[2]['total']) ? $prices[2]['total'] : 0));

		// debug user, price, and cart output
		//print_r($userCart);
		//print_r($prices);
		//print_r($this->Auth->user());

		// test user address entry data
		//$this->request->data['email'] = 'test';
		//$this->set('warning','Please verify that all required fields have been populated!');

		// check for address session values then import user provided data if signed in
		$userAddress = $this->Session->read('User.Address');
		$userShipAddress = $this->Session->read('User.ShipAddress');
		if(empty($userAddress) && empty($userShipAddress)){

			// check for user login status
			if ($this->Auth->user()){

				$userData = $this->Auth->user();

				// gather existing user addresses
				$options = array('conditions' => array(
													'Address.userId' => $userData['id'],
													'Address.type' => 'bill',
													));
				$address = $this->Address->find('first', $options);

				// add to address session variable if found
				if($address){

					$addressArr = array();

					$addressArr['email'] = $address['Address']['email'];
					$addressArr['firstName'] = $address['Address']['firstName'];
					$addressArr['lastName'] = $address['Address']['lastName'];
					$addressArr['company'] = $address['Address']['company'];
					$addressArr['telephone'] = $address['Address']['telephone'];
					$addressArr['fax'] = $address['Address']['fax'];
					$addressArr['address'] = $address['Address']['address'];
					$addressArr['address2'] = $address['Address']['address2'];
					$addressArr['city'] = $address['Address']['city'];
					$addressArr['state'] = $address['Address']['state'];
					$addressArr['postalCode'] = $address['Address']['postalCode'];

					$this->Session->write('User.Address', $addressArr);
				}

				$options = array('conditions' => array(
													'Address.userId' => $userData['id'],
													'Address.type' => 'ship',
													));
				$shipAddress = $this->Address->find('first', $options);

				// add to address session variable if found
				if($shipAddress){

					$shipAddressArr = array();

					$shipAddressArr['shipEmail'] = $shipAddress['Address']['email'];
					$shipAddressArr['shipFirstName'] = $shipAddress['Address']['firstName'];
					$shipAddressArr['shipLastName'] = $shipAddress['Address']['lastName'];
					$shipAddressArr['shipCompany'] = $shipAddress['Address']['company'];
					$shipAddressArr['shipTelephone'] = $shipAddress['Address']['telephone'];
					$shipAddressArr['shipFax'] = $shipAddress['Address']['fax'];
					$shipAddressArr['shipAddress'] = $shipAddress['Address']['address'];
					$shipAddressArr['shipAddress2'] = $shipAddress['Address']['address2'];
					$shipAddressArr['shipCity'] = $shipAddress['Address']['city'];
					$shipAddressArr['shipState'] = $shipAddress['Address']['state'];
					$shipAddressArr['shipPostalCode'] = $shipAddress['Address']['postalCode'];

					$this->Session->write('User.ShipAddress', $shipAddressArr);
				}

			}
		}

		// process submitted values
		if ($this->request->is('post')) {

			// create/update address session variables
			$addressArr = array();

			$addressArr['email'] = $this->request->data['email'];
			$addressArr['firstName'] = $this->request->data['firstName'];
			$addressArr['lastName'] = $this->request->data['lastName'];
			$addressArr['company'] = $this->request->data['company'];
			$addressArr['telephone'] = $this->request->data['telephone'];
			$addressArr['fax'] = $this->request->data['fax'];
			$addressArr['address'] = $this->request->data['address'];
			$addressArr['address2'] = $this->request->data['address2'];
			$addressArr['city'] = $this->request->data['city'];
			$addressArr['state'] = $this->request->data['state'];
			$addressArr['postalCode'] = $this->request->data['postalCode'];

			$this->Session->write('User.Address', $addressArr);

			$shipAddressArr = array();

			$shipAddressArr['shipEmail'] = $this->request->data['shipEmail'];
			$shipAddressArr['shipFirstName'] = $this->request->data['shipFirstName'];
			$shipAddressArr['shipLastName'] = $this->request->data['shipLastName'];
			$shipAddressArr['shipCompany'] = $this->request->data['shipCompany'];
			$shipAddressArr['shipTelephone'] = $this->request->data['shipTelephone'];
			$shipAddressArr['shipFax'] = $this->request->data['shipFax'];
			$shipAddressArr['shipAddress'] = $this->request->data['shipAddress'];
			$shipAddressArr['shipAddress2'] = $this->request->data['shipAddress2'];
			$shipAddressArr['shipCity'] = $this->request->data['shipCity'];
			$shipAddressArr['shipState'] = $this->request->data['shipState'];
			$shipAddressArr['shipPostalCode'] = $this->request->data['shipPostalCode'];

			$this->Session->write('User.ShipAddress', $shipAddressArr);

			// store supplied address information if all required fields are populated
			// check for billing address field entry
			if(!empty($this->request->data['email']) && !empty($this->request->data['firstName']) && !empty($this->request->data['lastName']) && !empty($this->request->data['company']) && !empty($this->request->data['telephone']) && !empty($this->request->data['address']) && !empty($this->request->data['city']) && !empty($this->request->data['state']) && !empty($this->request->data['postalCode'])){

				// check for shipping address entry
				if(!empty($this->request->data['shipEmail']) && !empty($this->request->data['shipFirstName']) && !empty($this->request->data['shipLastName']) && !empty($this->request->data['shipCompany']) && !empty($this->request->data['shipTelephone']) && !empty($this->request->data['shipAddress']) && !empty($this->request->data['shipCity']) && !empty($this->request->data['shipState']) && !empty($this->request->data['shipPostalCode'])){


					// verify all required payment information has been entered
					if(!empty($this->request->data['nameOnCard']) && !empty($this->request->data['cardNumber']) && !empty($this->request->data['cardExpYear']) && !empty($this->request->data['cardExpMonth']) && !empty($this->request->data['cardCVV'])){
						// send payment information to authorize.net for verification

						$billinginfo = array('fname' => $this->request->data['firstName'],
											'lname' => $this->request->data['lastName'],
											'address' => $this->request->data['address'].(!empty($this->request->data['address2']) ? ', '.$this->request->data['address2'] : ''),
											'city' => $this->request->data['city'],
											'state' => $this->request->data['state'],
											'zip' => $this->request->data['postalCode'],
											'country' => 'USA');

						$shippinginfo = array('fname' => $this->request->data['shipFirstName'],
											'lname' => $this->request->data['shipLastName'],
											'address' => $this->request->data['shipAddress'].(!empty($this->request->data['shipAddress2']) ? ', '.$this->request->data['shipAddress2'] : ''),
											'city' => $this->request->data['shipCity'],
											'state' => $this->request->data['shipState'],
											'zip' => $this->request->data['shipPostalCode'],
											'country' => 'USA');

						$response = $this->AuthorizeNet->chargeCard('login-id', 'trans-id', $this->request->data['cardNumber'], $this->request->data['cardExpMonth'], $this->request->data['cardExpYear'], $this->request->data['cardCVV'], true, $orderTotal, 0, (!empty($prices[2]['total']) ? $prices[2]['total'] : 0), 'CGO Online Order', $billinginfo, $this->request->data['email'], $this->request->data['telephone'], $shippinginfo); 

						// check response codes
						//$response[1] = 1;
						//print_r($response);
						if($response[1] == 1){
							// save order information

							// add product prices to user cart array before saving
							foreach($prices[0] as $idx => $val){
								$userCart[$idx]['price'] = $val;

								// update product quanities for products with enforced quantity values
								// gather product data
								$options = array('conditions' => array('Product.itemNumber' => $idx));
								$product = $this->Product->find('first', $options);

								// gather product type data
								$options = array('conditions' => array('ProductType.id' => $product['Product']['prodType']));
								$productType = $this->ProductType->find('first', $options);

								// if product uses enforce product qty within product type update saved product quanity
								if($productType['ProductType']['enforceQty'] === 1){
									$product['Product']['quantity'] = $product['Product']['quantity'] - $userCart[$idx]['qty'];
									$this->Product->save($product);
								}

							}

							// check for authenticated user, if not found look for user within db then create as needed
							if(!$this->Auth->user('id')){
								$options = array('conditions' => array('User.email' => $addressArr['email']));
								$user = $this->User->find('first', $options);
								// assign order to user if found
								if($user){
									$userId = $user['User']['id'];
								// create user if not found
								} else {
									$newUser = array(
										'email' => $addressArr['email'],
										'username' => $addressArr['email'],
										'password' => $this->randomPassword(),
									);

									$this->User->save($newUser);

									$userId = $this->User->getLastInsertId();
								}
							} else {
								$userId = $this->Auth->user('id');
							}

							// create new order array
							$newOrder = array(
								'userId' => $userId,
								'shipAddress' => serialize($shipAddressArr),
								'billAddress' => serialize($addressArr),
								'products' => serialize($userCart),
								'subTotal' => $prices[1],
								'tax' => 0,
								'shipping' => serialize($prices[2]),
								'total' => $prices[1],
								'status' => 'pending',
								'transactionId' => $response[7],
								'orderInstructions' => $this->request->data['orderInstructions'],
							);
							//print_r($newOrder);die();
							$this->Order->create();
							$this->Order->save($newOrder);
							$orderId = $this->Order->getLastInsertId();
							$this->Order->clear();


							$options = array('conditions' => array('Order.' . $this->Order->primaryKey => $orderId));

							// send out order emails
							App::uses('CakeEmail', 'Network/Email');

							$Email = new CakeEmail();
							$Email->template('invoice', 'default');
							$Email->viewVars(array('order' => $this->Order->find('first', $options)));
							$Email->to($this->request->data['email']);
							$Email->emailFormat('html');
							$Email->subject('CGO Order');
							$Email->replyTo('sales@customglassandoptics.com');
							$Email->from ('sales@customglassandoptics.com');
							$Email->send();

							// save updated address data
							$addressArr = array();

							$addressArr['Address.email'] = $this->request->data['email'];
							$addressArr['Address.firstName'] = $this->request->data['firstName'];
							$addressArr['Address.lastName'] = $this->request->data['lastName'];
							$addressArr['Address.company'] = $this->request->data['company'];
							$addressArr['Address.telephone'] = $this->request->data['telephone'];
							$addressArr['Address.fax'] = $this->request->data['fax'];
							$addressArr['Address.address'] = $this->request->data['address'];
							$addressArr['Address.address2'] = $this->request->data['address2'];
							$addressArr['Address.city'] = $this->request->data['city'];
							$addressArr['Address.state'] = $this->request->data['state'];
							$addressArr['Address.postalCode'] = $this->request->data['postalCode'];
							$addressArr['Address.userId'] = $this->Auth->user('id');
							$addressArr['Address.type'] = 'bill';

							$this->Address->save($addressArr);
							$this->Address->clear();

							$shipAddressArr = array();

							$shipAddressArr['Address.email'] = $this->request->data['shipEmail'];
							$shipAddressArr['Address.firstName'] = $this->request->data['shipFirstName'];
							$shipAddressArr['Address.lastName'] = $this->request->data['shipLastName'];
							$shipAddressArr['Address.company'] = $this->request->data['shipCompany'];
							$shipAddressArr['Address.telephone'] = $this->request->data['shipTelephone'];
							$shipAddressArr['Address.fax'] = $this->request->data['shipFax'];
							$shipAddressArr['Address.address'] = $this->request->data['shipAddress'];
							$shipAddressArr['Address.address2'] = $this->request->data['shipAddress2'];
							$shipAddressArr['Address.city'] = $this->request->data['shipCity'];
							$shipAddressArr['Address.state'] = $this->request->data['shipState'];
							$shipAddressArr['Address.postalCode'] = $this->request->data['shipPostalCode'];
							$shipAddressArr['Address.userId'] = $this->Auth->user('id');
							$shipAddressArr['Address.type'] = 'ship';

							$this->Address->save($shipAddressArr);
							$this->Address->clear();

							// redirect user to confirmation page
							return $this->redirect('/cart/confirm/?o='.$orderId);
						} else {

							$this->Session->setFlash(__('We are sorry, but your payment information appears to have been declined.'), 'alert', array(
								'plugin' => 'BoostCake',
								'class' => 'alert-warning'
							));
//								case 4:
//
//									// save order information
//
//									// add product prices to user cart array before saving
//									foreach($prices[0] as $idx => $val){
//										$userCart[$idx]['price'] = $val;
//									}
//
//									$newOrder = array(
//										'userId' => $itemNumber,
//										'shipAddress' => serialize($shipAddressArr),
//										'billAddress' => serialize($addressArr),
//										'products' => serialize($userCart),
//										'subTotal' => $prices[1],
//										'tax' => 0,
//										'shipping' => serialize($prices[2]),
//										'total' => $prices[1],
//										'status' => 'review',
//										'transactionId' => $response[7],
//										'orderInstructions' => $this->request->data['orderInstructions'],
//									);
//
//									$this->Order->create();
//									$this->Order->save($newOrder);
//									$this->Order->clear();
//
//									$this->set('warning','Your payment information has been held for review. Please contact CGO for further direction.');
//								break;
						}

					} else {
						$this->Session->setFlash(__('Please verify that all required payment fields have been populated!'), 'alert', array(
							'plugin' => 'BoostCake',
							'class' => 'alert-warning'
						));
					}
				} else {
					$this->Session->setFlash(__('Please verify that all required shipping address fields have been populated!'), 'alert', array(
						'plugin' => 'BoostCake',
						'class' => 'alert-warning'
					));
				}
			} else {
				$this->Session->setFlash(__('Please verify that all required billing address fields have been populated!'), 'alert', array(
					'plugin' => 'BoostCake',
					'class' => 'alert-warning'
				));
			}
		}

		// reload address data if assigned
		$addressArr = $this->Session->read('User.Address');
		if(!empty($addressArr)){
			$this->request->data['email'] = $addressArr['email'];
			$this->request->data['firstName'] = $addressArr['firstName'];
			$this->request->data['lastName'] = $addressArr['lastName'];
			$this->request->data['company'] = $addressArr['company'];
			$this->request->data['telephone'] = $addressArr['telephone'];
			$this->request->data['fax'] = $addressArr['fax'];
			$this->request->data['address'] = $addressArr['address'];
			$this->request->data['address2'] = $addressArr['address2'];
			$this->request->data['city'] = $addressArr['city'];
			$this->request->data['state'] = $addressArr['state'];
			$this->request->data['postalCode'] = $addressArr['postalCode'];
		}

		$shipAddressArr = $this->Session->read('User.ShipAddress');

		if(!empty($shipAddressArr)){
			$this->request->data['shipEmail'] = $shipAddressArr['shipEmail'];
			$this->request->data['shipFirstName'] = $shipAddressArr['shipFirstName'];
			$this->request->data['shipLastName'] = $shipAddressArr['shipLastName'];
			$this->request->data['shipCompany'] = $shipAddressArr['shipCompany'];
			$this->request->data['shipTelephone'] = $shipAddressArr['shipTelephone'];
			$this->request->data['shipFax'] = $shipAddressArr['shipFax'];
			$this->request->data['shipAddress'] = $shipAddressArr['shipAddress'];
			$this->request->data['shipAddress2'] = $shipAddressArr['shipAddress2'];
			$this->request->data['shipCity'] = $shipAddressArr['shipCity'];
			$this->request->data['shipState'] = $shipAddressArr['shipState'];
			$this->request->data['shipPostalCode'] = $shipAddressArr['shipPostalCode'];
		}

		// refresh provided payment information in case of error
		$this->set('nameOnCard',(isset($this->request->data['nameOnCard']) ? $this->request->data['nameOnCard'] : ''));
		$this->set('cardNumber',(isset($this->request->data['cardNumber']) ? $this->request->data['cardNumber'] : ''));
		$this->set('cardExpYear',(isset($this->request->data['cardExpYear']) ? $this->request->data['cardExpYear'] : ''));
		$this->set('cardExpMonth',(isset($this->request->data['cardExpMonth']) ? $this->request->data['cardExpMonth'] : ''));
		$this->set('cardCVV',(isset($this->request->data['cardCVV']) ? $this->request->data['cardCVV'] : ''));

		// assign values for the cart view
		$this->set('prices',$prices[0]);
		$this->set('subTotal',$prices[1]);
		$this->set('shipping',$prices[2]);
		$this->set('total',$orderTotal);
		$this->set('cart',$userCart);
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

	// add products to users cart
	public function add(){
		// disable layout and view
		$this->autoRender = false;

		// gather submitted cart data
		$userCart = $this->request->data('cart');

		// load existing cart to add/edit products
		$curCart = $this->Session->read('User.Cart');

		// initialize cart if empty
		if($curCart == NULL){
			$curCart = array();
		}

		// walk through cart objects and update cart as needed
		foreach($userCart as $idx => $item){
			// remove from cart when quantity is zero
			if($item['qty'] <= 0){
				if(isset($curCart[$idx])){
					unset($curCart[$idx]);
				}
			// remove item from cart if minimum purchase price is set and not yet met
			} else if($item['minPurchasePrice'] > 0 && $item['total'] < $item['minPurchasePrice']){
				if(isset($curCart[$idx])){
					unset($curCart[$idx]);
				}
			} else {
				$curCart[$idx] = $item;
			}
		}

		// store updated cart values
		$this->Session->write('User.Cart', $curCart);
	}

	// remove product from cart
	public function delete(){
		// disable layout and view
		$this->autoRender = false;

		// load existing cart to add/edit products
		$curCart = $this->Session->read('User.Cart');

		// remove selected item
		unset($curCart[$this->request->data('itemNumber')]);

		// store updated cart values
		$this->Session->write('User.Cart', $curCart);
	}

}
