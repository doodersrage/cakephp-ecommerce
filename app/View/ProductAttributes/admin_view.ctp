<div class="productAttributes view">
<h2><?php echo __('Product Attribute'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($productAttribute['ProductAttribute']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('AttributeId'); ?></dt>
		<dd>
			<?php echo h($productAttribute['ProductAttribute']['attributeId']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('itemNumber'); ?></dt>
		<dd>
			<?php echo h($productAttribute['ProductAttribute']['itemNumber']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Content'); ?></dt>
		<dd>
			<?php echo h($productAttribute['ProductAttribute']['content']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Product Attribute'), array('action' => 'edit', $productAttribute['ProductAttribute']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Product Attribute'), array('action' => 'delete', $productAttribute['ProductAttribute']['id']), array(), __('Are you sure you want to delete # %s?', $productAttribute['ProductAttribute']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Product Attributes'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Product Attribute'), array('action' => 'add')); ?> </li>
	</ul>
</div>
