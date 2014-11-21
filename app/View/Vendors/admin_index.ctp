<div class="col-lg-9 vendors index">
	<h2><?php echo __('Vendors'); ?></h2>
	<div class="table-responsive">
	<table class="table table-striped">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('contactName'); ?></th>
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
	<?php foreach ($vendors as $vendor): ?>
	<tr>
		<td><?php echo h($vendor['Vendor']['id']); ?>&nbsp;</td>
		<td><?php echo h($vendor['Vendor']['name']); ?>&nbsp;</td>
		<td><?php echo h($vendor['Vendor']['contactName']); ?>&nbsp;</td>
		<td><?php echo h($vendor['Vendor']['telephone']); ?>&nbsp;</td>
		<td><?php echo h($vendor['Vendor']['fax']); ?>&nbsp;</td>
		<td><?php echo h($vendor['Vendor']['address']); ?>&nbsp;</td>
		<td><?php echo h($vendor['Vendor']['address2']); ?>&nbsp;</td>
		<td><?php echo h($vendor['Vendor']['city']); ?>&nbsp;</td>
		<td><?php echo h($vendor['Vendor']['state']); ?>&nbsp;</td>
		<td><?php echo h($vendor['Vendor']['postalCode']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $vendor['Vendor']['id']), array('class'=>'btn btn-primary')); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $vendor['Vendor']['id']), array('class'=>'btn btn-primary')); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $vendor['Vendor']['id']), array('class'=>'btn btn-primary'), __('Are you sure you want to delete # %s?', $vendor['Vendor']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Vendor'), array('action' => 'add'),array('class'=>'btn btn-primary')); ?></li>
	</ul>
</div>
