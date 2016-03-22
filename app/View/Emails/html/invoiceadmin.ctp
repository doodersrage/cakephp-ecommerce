		<?php 
		if(!empty($order)){
			$billAddress = unserialize($order['Order']['billAddress']);
			$shipAddress = unserialize($order['Order']['shipAddress']);
			$products = unserialize($order['Order']['products']);
			$shipping = unserialize($order['Order']['shipping']);
		?>
            <table border="1" cellpadding="3" cellspacing="0" width="670">
            	<tr>
                	<td colspan="7" style="text-align:left"><img src="http://cs.studiocenter.com/img/cgs-logo.png" style="width:175px;height:auto" id="logo" alt="custom silicon and glass logo image"></td>
                </tr>
            	<tr>
                	<td colspan="2" style="text-align:left;padding:5px" valign="top">
                        <h4>Billing Address</h4>
                        <p><?php
						echo 'Email: '.$billAddress['email'].'<br>';
						echo 'First Name: '.$billAddress['firstName'].'<br>';
						echo 'Last Name: '.$billAddress['lastName'].'<br>';
						echo 'Company: '.$billAddress['company'].'<br>';
						echo 'Telephone: '.$billAddress['telephone'].'<br>';
						if(!empty($billAddress['fax'])){
							echo 'Fax: '.$billAddress['fax'].'<br>';
						}
						echo 'Address: '.$billAddress['address'].'<br>';
						if(!empty($billAddress['address2'])){
							echo 'Address2: '.$billAddress['address2'].'<br>';
						}
						echo 'City: '.$billAddress['city'].'<br>';
						echo 'State: '.$billAddress['state'].'<br>';
						echo 'Zip: '.$billAddress['postalCode'];
						?></p>
                    </td>
                	<td colspan="2" style="text-align:left;padding:5px" valign="top">
                        <h4>Shipping Address</h4>
                        <?php
						echo 'Email: '.$shipAddress['shipEmail'].'<br>';
						echo 'First Name: '.$shipAddress['shipFirstName'].'<br>';
						echo 'Last Name: '.$shipAddress['shipLastName'].'<br>';
						echo 'Company: '.$shipAddress['shipCompany'].'<br>';
						echo 'Telephone: '.$shipAddress['shipTelephone'].'<br>';
						if(!empty($shipAddress['shipFax'])){
							echo 'Fax: '.$shipAddress['shipFax'].'<br>';
						}
						echo 'Address: '.$shipAddress['shipAddress'].'<br>';
						if(!empty($shipAddress['shipAddress2'])){
							echo 'Address2: '.$shipAddress['shipAddress2'].'<br>';
						}
						echo 'City: '.$shipAddress['shipCity'].'<br>';
						echo 'State: '.$shipAddress['shipState'].'<br>';
						echo 'Zip: '.$shipAddress['shipPostalCode'];
						?>
                    </td>
                    <td colspan="3" valign="top">
                    <h4>Order Date/Time</h4>
                    <p><?php
					echo date("F j, Y, g:i a",strtotime($order['Order']['dateOrdered']));
					?></p>
                    </td>
                </tr>
            	<tr>
                	<th>ITEM NUMBER</th>
                	<th>LENGTH</th>
                	<th>WIDTH</th>
                	<th>QUANTITY</th>
                	<th>TOTAL</th>
                	<th>SHIP DATE</th>
                	<th>FREIGHT CHARGE</th>
                </tr>
            <?php
			foreach($products as $idx => $val){
				echo '<tr class="'.preg_replace('/[^a-z0-9]+/i', '_', $idx).'">';
				echo '<td>'.$idx.'</td>';
				echo '<td>'.(!empty($val['length']) ? $val['length'] : 'N/A').'</td>';
				echo '<td>'.(!empty($val['width']) ? $val['width'] : 'N/A').'</td>';
				echo '<td>'.$val['qty'].'</td>';
				echo '<td>$<span class="price">'.number_format($val['price'],2).'</span></td>';
				echo (isset($shipping[$idx]['shipDate']) ? '<td>'.$shipping[$idx]['shipDate'].'</td>' : '<td>TBD</td>');
				echo (isset($shipping[$idx]['selShipCost']) ? '<td>$<span class="shipping">'.number_format($shipping[$idx]['selShipCost'],2).'</span></td>' : '<td>TBA</td>');
				echo '</tr>';
			}
			?>
            <tr>
                <td colspan="5" style="text-align:right">SUB-TOTAL:</td>
                <td>$<span class="subTotal"><?php echo number_format($order['Order']['subTotal'],2,'.',','); ?></span></td>
            </tr>
           	<tr>
                	<td colspan="5" style="text-align:right">SHIPPING:</td>
                	<td>$<span class="subTotal"><?php echo number_format((isset($shipping['total']) ? $shipping['total'] : 0),2,'.',','); ?></span></td>
                </tr>
            	<tr>
                	<td colspan="5" style="text-align:right">TOTAL:</td>
                	<td>$<span class="subTotal"><?php echo number_format($order['Order']['total'],2,'.',','); ?></span></td>
                </tr>
            	<tr>
                	<td colspan="4">
					 <?php
                     switch($order['Order']['status']){
						 case 'processing':
						 	echo '<p>Your order has been updated with planned ship date(s), shipping and packaging charges (if applicable).  Please contact us immediately if you have any questions or issues with this information. Otherwise, we will proceed to fill the order and charge your credit card accordingly.</p>';
						 break;
						 case 'shipping':
						 	echo '<p>Your order has shipped and your credit card has been charged accordingly.  Thank you for working with us.  We look forward to servicing your future needs.</p>';
						 break;
						 case 'delivered':
						 	echo '<p>Your order has been delivered and your credit card charged accordingly.  Please contact us if there is anything more you need.</p>';
						 break;
						 case 'pending':
						 default:
						 	echo '<p>Thank you for your order, it has been received and entered into our system.  You will receive a follow up email confirming ship date(s) and freight charges if applicable. </p>';
						 break;
					 };
                    ?>
                    <h4>Order Notes</h4>
					 <?php
                     echo $order['Order']['notes'];
                    ?>
                    </td>
                	<td colspan="3">
                        <h4>Order Instructions</h4>
                         <?php
						 echo $order['Order']['orderInstructions'];
						?>
                   </td>
                </tr>
            </table>
            <?php
		} else {
			echo '<p>Your recent orders list appears to be empty!</p>';
		}
		?>
