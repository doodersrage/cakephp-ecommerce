<div class="page-head">
    <h1>Order View</h1>
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
		if(!empty($order)){
			$billAddress = unserialize($order['Order']['billAddress']);
			$shipAddress = unserialize($order['Order']['shipAddress']);
			$products = unserialize($order['Order']['products']);
			$shipping = unserialize($order['Order']['shipping']);
		?>
            <table>
            	<tr>
                	<td colspan="2" style="text-align:left;padding:5px">
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
                	<td colspan="2" style="text-align:left;padding:5px">
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
                    <td colspan="3">
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
                	<th>SHIPPING</th>
                </tr>
            <?php
			foreach($products as $idx => $val){
				echo '<tr class="'.preg_replace('/[^a-z0-9]+/i', '_', $idx).'">';
				echo '<td><a href="'.$val['url'].'">'.$idx.'</a></td>';
				echo '<td>'.(!empty($val['length']) ? $val['length'] : 'N/A').'</td>';
				echo '<td>'.(!empty($val['width']) ? $val['width'] : 'N/A').'</td>';
				echo '<td>'.$val['qty'].'</td>';
				echo '<td>$<span class="price">'.number_format($val['price'],2).'</span></td>';
				echo (isset($shipping[$idx]['selShipCost']) ? '<td>$<span class="shipping">'.number_format($shipping[$idx]['selShipCost'],2).'</span></td>' : '<td>TBA</td>');
				echo '</tr>';
			}
			?>
            	<tr>
                	<td colspan="5" style="text-align:right">SHIPPING:</td>
                	<td>$<span class="subTotal"><?php echo number_format((isset($shipping['total']) ? $shipping['total'] : 0),2,'.',','); ?></span></td>
                </tr>
            	<tr>
                	<td colspan="5" style="text-align:right">SUB-TOTAL:</td>
                	<td>$<span class="subTotal"><?php echo number_format($order['Order']['subTotal'],2,'.',','); ?></span></td>
                </tr>
            	<tr>
                	<td colspan="5" style="text-align:right">TOTAL:</td>
                	<td>$<span class="subTotal"><?php echo number_format($order['Order']['total'],2,'.',','); ?></span></td>
                </tr>
            	<tr>
                	<td colspan="4">&nbsp;</td>
                	<td colspan="3">
                        <h4>Order Instructions</h4>
                         <?php
						 echo $order['Order']['orderInstructions'];
						?>
                   </td>
                </tr>
            </table>
            <p style="text-align:center"><strong><a target="_blank" href="/orders/invoice/<?php echo $order['Order']['id']; ?>">Click here to print invoice.</a></strong></p>
            <?php
		} else {
			echo '<p>Your recent orders list appears to be empty!</p>';
		}
		?>
		</div>
	</div>
</div>