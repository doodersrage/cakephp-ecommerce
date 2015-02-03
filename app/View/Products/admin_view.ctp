<div class="col-lg-9 col-md-9 products view">
<h2><?php echo __('Product'); ?></h2>
	<dl>
		<dt><?php echo __('ItemNumber'); ?></dt>
		<dd>
			<?php echo h($product['Product']['itemNumber']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Price'); ?></dt>
		<dd>
			<?php echo h($product['Product']['price']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Quantity'); ?></dt>
		<dd>
			<?php echo h($product['Product']['quantity']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('ProdType'); ?></dt>
		<dd>
			<?php echo h($productType['ProductType']['title']); ?>
			&nbsp;
		</dd>
	</dl>
	<h3><?php echo __('Attributes'); ?></h3>
	<dl>
		<?php
		foreach($attributes as $attribute){
			echo '<dt>'.$attributeTypes[$attribute['ProductAttribute']['attributeId']].'</dt>';
			echo '<dd>'.$attribute['ProductAttribute']['content'].'</dd>';
		}
		?>
	</dl>
</div>
<div class="col-lg-3 col-md-3 actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Product'), array('action' => 'edit', $product['Product']['itemNumber']), array('class'=>'btn btn-primary')); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Product'), array('action' => 'delete', $product['Product']['itemNumber']), array('class'=>'btn btn-primary'), __('Are you sure you want to delete # %s?', $product['Product']['itemNumber']), array('class'=>'btn btn-primary')); ?> </li>
		<li><?php echo $this->Html->link(__('List Products'), array('action' => 'index'), array('class'=>'btn btn-primary')); ?> </li>
		<li><?php echo $this->Html->link(__('New Product'), array('action' => 'add'), array('class'=>'btn btn-primary')); ?> </li>
	</ul>
</div>
