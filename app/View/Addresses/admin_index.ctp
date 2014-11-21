<div class="col-lg-9 addresses index">
	<h2><?php echo __('Addresses'); ?></h2>
	<div class="table-responsive">
	<table class="table table-striped">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('userId'); ?></th>
			<th><?php echo $this->Paginator->sort('firstName'); ?></th>
			<th><?php echo $this->Paginator->sort('lastName'); ?></th>
			<th><?php echo $this->Paginator->sort('company'); ?></th>
			<th><?php echo $this->Paginator->sort('telephone'); ?></th>
			<th><?php echo $this->Paginator->sort('fax'); ?></th>
			<th><?php echo $this->Paginator->sort('address'); ?></th>
			<th><?php echo $this->Paginator->sort('address2'); ?></th>
			<th><?php echo $this->Paginator->sort('city'); ?></th>
			<th><?php echo $this->Paginator->sort('state'); ?></th>
			<th><?php echo $this->Paginator->sort('postalCode'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($addresses as $address): ?>
	<tr>
		<td><?php echo h($address['Address']['id']); ?>&nbsp;</td>
		<td><?php echo h($address['Address']['userId']); ?>&nbsp;</td>
		<td><?php echo h($address['Address']['firstName']); ?>&nbsp;</td>
		<td><?php echo h($address['Address']['lastName']); ?>&nbsp;</td>
		<td><?php echo h($address['Address']['company']); ?>&nbsp;</td>
		<td><?php echo h($address['Address']['telephone']); ?>&nbsp;</td>
		<td><?php echo h($address['Address']['fax']); ?>&nbsp;</td>
		<td><?php echo h($address['Address']['address']); ?>&nbsp;</td>
		<td><?php echo h($address['Address']['address2']); ?>&nbsp;</td>
		<td><?php echo h($address['Address']['city']); ?>&nbsp;</td>
		<td><?php echo h($address['Address']['state']); ?>&nbsp;</td>
		<td><?php echo h($address['Address']['postalCode']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $address['Address']['id']), array('class'=>'btn btn-primary')); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $address['Address']['id']), array('class'=>'btn btn-primary')); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $address['Address']['id']), array('class'=>'btn btn-primary'), __('Are you sure you want to delete # %s?', $address['Address']['id'])); ?>
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
<div class="col-lg-3 actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Address'), array('action' => 'add'), array('class'=>'btn btn-primary')); ?></li>
	</ul>
</div>
