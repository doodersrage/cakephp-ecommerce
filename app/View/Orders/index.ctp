<div class="page-head">
    <h1>Orders</h1>
</div>

<div class="bread-crumbs">
    <a href="#">Home</a>
</div>

<div class="row marketing">
    <div class="row" style="padding:20px">
	<div class="table-responsive">
	<table>
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('dateOrdered'); ?></th>
			<th><?php echo $this->Paginator->sort('Billing'); ?></th>
			<th><?php echo $this->Paginator->sort('Shipping'); ?></th>
			<th><?php echo $this->Paginator->sort('subTotal'); ?></th>
			<th><?php echo $this->Paginator->sort('tax'); ?></th>
			<th><?php echo $this->Paginator->sort('shipping'); ?></th>
			<th><?php echo $this->Paginator->sort('total'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($orders as $order): ?>
	<tr>
		<td><a href="/orders/view/<?php echo h($order['Order']['id']); ?>"><?php echo h($order['Order']['id']); ?></a>&nbsp;</td>
		<td><a href="/orders/view/<?php echo h($order['Order']['id']); ?>"><?php echo date("F j, Y, g:i a",strtotime($order['Order']['dateOrdered'])); ?></a></td>
		<td><?php 
				$billAddress = unserialize($order['Order']['billAddress']);
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
		?></td>
		<td><?php $shipAddress = unserialize($order['Order']['shipAddress']);
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
		<td>$<?php echo number_format($order['Order']['subTotal'],2,'.',','); ?>&nbsp;</td>
		<td>$<?php echo number_format($order['Order']['tax'],2,'.',','); ?>&nbsp;</td>
		<td>$<?php $shipping = unserialize($order['Order']['shipping']); 
				if(!empty($shipping['total'])){ echo number_format($shipping['total'],2,'.',','); }else{ echo 0.00; } ?>&nbsp;</td>
		<td>$<?php echo number_format($order['Order']['total'],2,'.',','); ?>&nbsp;</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
	</div>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<ul class="pager">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</ul>
    </div>
</div>
