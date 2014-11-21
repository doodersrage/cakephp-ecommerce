<div class="col-lg-9 productAttributeTypes view">
<h2><?php echo __('Product Attribute Type'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($productAttributeType['ProductAttributeType']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Title'); ?></dt>
		<dd>
			<?php echo h($productAttributeType['ProductAttributeType']['title']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="col-lg-3 actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Product Attribute Type'), array('action' => 'edit', $productAttributeType['ProductAttributeType']['id']),array('class'=>'btn btn-primary')); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Product Attribute Type'), array('action' => 'delete', $productAttributeType['ProductAttributeType']['id']), array(), __('Are you sure you want to delete # %s?', $productAttributeType['ProductAttributeType']['id']),array('class'=>'btn btn-primary')); ?> </li>
		<li><?php echo $this->Html->link(__('List Product Attribute Types'), array('action' => 'index'),array('class'=>'btn btn-primary')); ?> </li>
		<li><?php echo $this->Html->link(__('New Product Attribute Type'), array('action' => 'add'),array('class'=>'btn btn-primary')); ?> </li>
	</ul>
</div>
