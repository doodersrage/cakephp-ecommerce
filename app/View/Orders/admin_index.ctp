<div class="col-lg-9 orders index">
	<h2><?php echo __('Orders'); ?></h2>
	<div class="table-responsive">
	<table class="table table-striped">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('shipAddressId'); ?></th>
			<th><?php echo $this->Paginator->sort('billAddressId'); ?></th>
			<th><?php echo $this->Paginator->sort('subTotal'); ?></th>
			<th><?php echo $this->Paginator->sort('tax'); ?></th>
			<th><?php echo $this->Paginator->sort('shipping'); ?></th>
			<th><?php echo $this->Paginator->sort('total'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($orders as $order): ?>
	<tr>
		<td><?php echo h($order['Order']['id']); ?>&nbsp;</td>
		<td><?php echo h($order['Order']['shipAddressId']); ?>&nbsp;</td>
		<td><?php echo h($order['Order']['billAddressId']); ?>&nbsp;</td>
		<td><?php echo h($order['Order']['subTotal']); ?>&nbsp;</td>
		<td><?php echo h($order['Order']['tax']); ?>&nbsp;</td>
		<td><?php echo h($order['Order']['shipping']); ?>&nbsp;</td>
		<td><?php echo h($order['Order']['total']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $order['Order']['id']), array('class'=>'btn btn-primary')); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $order['Order']['id']), array('class'=>'btn btn-primary')); ?>
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
<div class="col-lg-6 sidebar actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Order'), array('action' => 'add'),array('class'=>'btn btn-primary')); ?></li>
	</ul>
</div>
