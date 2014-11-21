<div class="col-lg-9 productAttributes index">
	<h2><?php echo __('Product Attributes'); ?></h2>
	<div class="table-responsive">
	<table class="table table-striped">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('attributeId'); ?></th>
			<th><?php echo $this->Paginator->sort('itemNumber'); ?></th>
			<th><?php echo $this->Paginator->sort('content'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($productAttributes as $productAttribute): ?>
	<tr>
		<td><?php echo h($productAttribute['ProductAttribute']['id']); ?>&nbsp;</td>
		<td><?php echo h($productAttribute['ProductAttribute']['attributeId']); ?>&nbsp;</td>
		<td><?php echo h($productAttribute['ProductAttribute']['itemNumber']); ?>&nbsp;</td>
		<td><?php echo h($productAttribute['ProductAttribute']['content']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $productAttribute['ProductAttribute']['id']), array('class'=>'btn btn-primary')); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $productAttribute['ProductAttribute']['id']), array('class'=>'btn btn-primary')); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $productAttribute['ProductAttribute']['id']), array('class'=>'btn btn-primary'), __('Are you sure you want to delete # %s?', $productAttribute['ProductAttribute']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Product Attribute'), array('action' => 'add'),array('class'=>'btn btn-primary')); ?></li>
	</ul>
</div>
