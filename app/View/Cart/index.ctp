<div class="page-head">
    <h1>Shopping Cart</h1>
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
				echo '<td>'.(!empty($val['length']) ? $val['length'] : 'N/A').'</td>';
				echo '<td>'.(!empty($val['width']) ? $val['width'] : 'N/A').'</td>';
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
                	<td colspan="6"></td>
                	<td><form action="/cart/checkout"><button type="submit">Check Out</button></form></td>
                </tr>
            </table>
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
            </script>
            <?php
		} else {
			echo '<p>Your shopping cart appears to be empty!</p>';
		}
		?>
		</div>
	</div>
</div>