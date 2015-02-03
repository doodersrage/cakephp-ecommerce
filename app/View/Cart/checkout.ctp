<div class="page-head">
    <h1>Checkout</h1>
</div>

<div class="bread-crumbs">
    <a href="#">Home</a>
</div>
<?php
// flash warning message
echo $this->Session->flash();
?>

<div class="row marketing">
    <div class="row">
		<div class="col-lg-12">
		<?php 
		if(!empty($cart)){
			?>
            <form action="/cart/checkout" method="post">
            <table>
            	<tr>
                	<th>ITEM NUMBER</th>
                	<th>LENGTH</th>
                	<th>WIDTH</th>
                	<th>QUANTITY</th>
                	<th>TOTAL</th>
                	<th>SHIPPING</th>
                	<th>DELETE</th>
                </tr>
            <?php
			foreach($cart as $idx => $val){
				echo '<tr class="'.preg_replace('/[^a-z0-9]+/i', '_', $idx).'">';
				echo '<td><a href="'.$val['url'].'">'.$idx.'</a></td>';
				echo '<td>'.(!empty($val['length']) ? $val['length'] : '').'</td>';
				echo '<td>'.(!empty($val['width']) ? $val['width'] : '').'</td>';
				echo '<td>'.$val['qty'].'</td>';
				echo '<td>$<span class="price">'.number_format($prices[$idx],2).'</span></td>';
				echo (isset($shipping[$idx]['selShipCost']) ? '<td>$<span class="shipping">'.number_format($shipping[$idx]['selShipCost'],2).'</span></td>' : '<td>TBA</td>');
				echo '<td><a href="javascript: void(0)" onClick="deleteProduct(\''.preg_replace('/[^a-z0-9]+/i', '_', $idx).'\')" >'. $this->Html->image('red-x.png') . '</a></td>';
				echo '</tr>';
			}
			?>
            	<tr>
                	<td colspan="6" style="text-align:right">SUB-TOTAL:</td>
                	<td>$<span class="subTotal"><?php echo number_format($subTotal,2,'.',','); ?></span></td>
                </tr>
            	<tr>
                	<td colspan="6" style="text-align:right">SHIPPING:</td>
                	<td>$<span class="subTotal"><?php echo number_format((isset($shipping['total']) ? $shipping['total'] : 0),2,'.',','); ?></span></td>
                </tr>
            	<tr>
                	<td colspan="6" style="text-align:right">TOTAL:</td>
                	<td>$<span class="subTotal"><?php echo number_format($total,2,'.',','); ?></span></td>
                </tr>
            	<tr>
                	<td colspan="7" style="text-align:center"><div class="warning"><?php echo (isset($warning) ? $warning : ''); ?></div></td>
                </tr>
            	<tr>
                	<td colspan="2" style="text-align:left;padding:5px">
                    <h4>Billing Address</h4>
                    <small>* indicates required</small>
                    <?php
					echo $this->Form->input('email', array('label'=>'Email: *','required'=>'required','class'=>'billAddress'));
					echo $this->Form->input('firstName', array('label'=>'First Name: *','required'=>'required','class'=>'billAddress'));
					echo $this->Form->input('lastName', array('label'=>'Last Name: *','required'=>'required','class'=>'billAddress'));
					echo $this->Form->input('company', array('label'=>'Company: *','required'=>'required','class'=>'billAddress'));
					echo $this->Form->input('telephone', array('label'=>'Telephone: *','required'=>'required','type'=>'tel','class'=>'billAddress'));
					echo $this->Form->input('fax', array('label'=>'Fax:','type'=>'tel','class'=>'billAddress'));
					echo $this->Form->input('address', array('label'=>'Address: *','required'=>'required','class'=>'billAddress'));
					echo $this->Form->input('address2', array('label'=>'Address2:','class'=>'billAddress'));
					echo $this->Form->input('city', array('label'=>'City: *','required'=>'required','class'=>'billAddress'));
					echo $this->Form->input('state', array('label'=>'State: *','required'=>'required','class'=>'billAddress'));
					echo $this->Form->input('postalCode', array('label'=>'Zip: *','required'=>'required','class'=>'billAddress'));
					echo $this->Form->label('Shipping Address Same as Billing?').'<br>';
					echo $this->Form->checkbox('shipSameAsBilling');
					?>
                    </td>
                	<td colspan="2" style="text-align:left;padding:5px">
                    <h4>Shipping Address</h4>
                    <?php
					echo $this->Form->input('shipEmail', array('label'=>'Email: *','required'=>'required'));
					echo $this->Form->input('shipFirstName', array('label'=>'First Name: *','required'=>'required'));
					echo $this->Form->input('shipLastName', array('label'=>'Last Name: *','required'=>'required'));
					echo $this->Form->input('shipCompany', array('label'=>'Company: *','required'=>'required'));
					echo $this->Form->input('shipTelephone', array('label'=>'Telephone: *','required'=>'required','type'=>'tel'));
					echo $this->Form->input('shipFax', array('label'=>'Fax:','type'=>'tel'));
					echo $this->Form->input('shipAddress', array('label'=>'Address: *','required'=>'required'));
					echo $this->Form->input('shipAddress2', array('label'=>'Address2:'));
					echo $this->Form->input('shipCity', array('label'=>'City: *','required'=>'required'));
					echo $this->Form->input('shipState', array('label'=>'State: *','required'=>'required'));
					echo $this->Form->input('shipPostalCode', array('label'=>'Zip: *','required'=>'required'));
					?>
                    </td>
                	<td colspan="3">
                    <h4>Payment Method</h4>
                    <?php
						echo $this->Form->input('nameOnCard', array('label'=>'Name on Card:','required'=>'required'));
						echo $this->Form->input('cardNumber', array('label'=>'Card Number:','required'=>'required'));
						
						// define user selectable months
						$months = array();
						$months['01'] = '01';
						$months['02'] = '02';
						$months['03'] = '03';
						$months['04'] = '04';
						$months['05'] = '05';
						$months['06'] = '06';
						$months['07'] = '07';
						$months['08'] = '08';
						$months['09'] = '09';
						$months['10'] = '10';
						$months['11'] = '11';
						$months['12'] = '12';
						
						echo $this->Form->input('cardExpMonth', array('label'=>'Card Expiration Month:','required'=>'required','options'=>$months));
						
						// define user selectable years
						$years = array();
						for($i = date('Y'); $i < date('Y')+10; $i++){
							$years[$i] = $i;
						}
						
						echo $this->Form->input('cardExpYear', array('label'=>'Card Expiration Year:','required'=>'required','options'=>$years));
						echo $this->Form->input('cardCVV', array('label'=>'Card CVV/CVV2/CSC:','required'=>'required'));
					?><a href="https://www.cvvnumber.com/cvv.html" target="_blank" style="font-size:11px">What is my CVV code?</a><br><br>
                    <h4>Special Order Instructions</h4>
                    <?php
						echo $this->Form->input('orderInstructions', array('label'=>'Please enter any special instructions for your order below.','type' => 'textarea'));
					?>
                    </td>
                </tr>
            	<tr>
                	<td colspan="6"></td>
                	<td><button type="submit">Submit Payment</button></td>
                </tr>
            </table></form>
			<script>
                var deleteProduct = function(idx)
                {                
                    var r = confirm("Are you sure?");
                    if (r == true) {
                        // perform ajax request
                        jQuery.post('<?php echo Router::Url(array('controller' => 'cart','admin' => false, 'action' => 'delete'), TRUE); ?>',
                            { itemNumber: idx }, function(response) {
                        });
						// update price
						var prodPrice = Number($('.'+idx+' .price').html());
						var subTotal = Number($('.subTotal').html());
						var newSubTotal = subTotal-prodPrice;
						$('.subTotal').html(newSubTotal.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'));
						// remove selected item
						$('.'+idx).remove();
                    }
                    return false;
                }
				
				var updateFormVals = function(){
					if($('#shipSameAsBilling').is(':checked')) {
						// copy form values
						$('#shipEmail').val($('#email').val());
						$('#shipFirstName').val($('#firstName').val());
						$('#shipLastName').val($('#lastName').val());
						$('#shipCompany').val($('#company').val());
						$('#shipTelephone').val($('#telephone').val());
						$('#shipFax').val($('#fax').val());
						$('#shipAddress').val($('#address').val());
						$('#shipAddress2').val($('#address2').val());
						$('#shipCity').val($('#city').val());
						$('#shipState').val($('#state').val());
						$('#shipPostalCode').val($('#postalCode').val());
					}
				}
				
				var resetShippingAddress = function(){
					// reset form values
					$('#shipEmail').val('');
					$('#shipFirstName').val('');
					$('#shipLastName').val('');
					$('#shipCompany').val('');
					$('#shipTelephone').val('');
					$('#shipFax').val('');
					$('#shipAddress').val('');
					$('#shipAddress2').val('');
					$('#shipCity').val('');
					$('#shipState').val('');
					$('#shipPostalCode').val('');
				}
				
				// update form values if same as billing is checked
				$(function(){
					updateFormVals();
					// update form values on shipping/billing address preferences click
					$('#shipSameAsBilling').click(function(){
						if($('#shipSameAsBilling').is(':checked')) {
							updateFormVals();
						} else {
							resetShippingAddress();
						}
					});
					
					// update values on change
					$('.billAddress').keyup(function(){
						if($('#shipSameAsBilling').is(':checked')) {
							updateFormVals();
						}
					});
				});
				
            </script>
            <style>
			.warning{
				color:#fff;
				background:#FF0004;
				font-weight:700;
				font-size:20px;
			}
			</style>
            <?php
		} else {
			echo '<p>Your shopping cart appears to be empty!</p>';
		}
		?>
		</div>
	</div>
</div>