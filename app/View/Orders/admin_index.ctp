<div class="col-lg-9 col-md-9 orders index">
	<h2><?php echo __('Orders'); ?></h2>
	<div class="table-responsive">
	<table class="table table-striped">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('billAddress'); ?></th>
			<th><?php echo $this->Paginator->sort('shipAddress'); ?></th>
			<th><?php echo $this->Paginator->sort('subTotal'); ?></th>
			<th><?php echo $this->Paginator->sort('tax'); ?></th>
			<th><?php echo $this->Paginator->sort('shipping'); ?></th>
			<th><?php echo $this->Paginator->sort('total'); ?></th>
			<th><?php echo $this->Paginator->sort('date/time'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($orders as $order): ?>
	<tr>
		<td><?php echo h($order['Order']['id']); ?>&nbsp;</td>
		<td><?php 
				$billAddress = unserialize($order['Order']['billAddress']);
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
		?></td>
		<td><?php $shipAddress = unserialize($order['Order']['shipAddress']);
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
		<td>$<?php echo number_format($order['Order']['subTotal'],2,'.',','); ?>&nbsp;</td>
		<td>$<?php echo number_format($order['Order']['tax'],2,'.',','); ?>&nbsp;</td>
		<td>$<?php $shipping = unserialize($order['Order']['shipping']); 
				if(!empty($shipping['total'])){ echo number_format($shipping['total'],2,'.',','); }else{ echo 0.00; } ?>&nbsp;</td>
		<td>$<?php echo number_format($order['Order']['total'],2,'.',','); ?>&nbsp;</td>
		<td><?php echo date("F j, Y, g:i a",strtotime($order['Order']['dateOrdered'])); ?></td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $order['Order']['id']), array('class'=>'btn btn-primary')); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $order['Order']['id']), array('class'=>'btn btn-primary'), __('Are you sure you want to delete # %s?', $order['Order']['id'])); ?>
		</td>
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
<div class="col-lg-3 col-md-3 sidebar actions">
	<h3><?php echo __('Actions'); ?></h3>
</div>
