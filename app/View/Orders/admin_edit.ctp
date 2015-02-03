<div class="ocol-lg-9 col-md-9 rders form">
<?php echo $this->Form->create('Order'); ?>
	<fieldset>
		<legend><?php echo __('Edit Order'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('shipAddressId', array('class'=>'form-control',));
		echo $this->Form->input('billAddressId', array('class'=>'form-control',));
		echo $this->Form->input('subTotal', array('class'=>'form-control',));
		echo $this->Form->input('tax', array('class'=>'form-control',));
		echo $this->Form->input('shipping', array('class'=>'form-control',);
		echo $this->Form->input('total', array('class'=>'form-control',));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="col-lg-3 col-md-3 actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Order.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('Order.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Orders'), array('action' => 'index')); ?></li>
	</ul>
</div>
