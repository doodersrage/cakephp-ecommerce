<div class="col-lg-9 orders form">
<?php echo $this->Form->create('Order'); ?>
	<fieldset>
		<legend><?php echo __('Add Order'); ?></legend>
	<?php
		echo $this->Form->input('shipAddressId', array('class'=>'form-control',));
		echo $this->Form->input('billAddressId', array('class'=>'form-control',));
		echo $this->Form->input('subTotal', array('class'=>'form-control',));
		echo $this->Form->input('tax', array('class'=>'form-control',));
		echo $this->Form->input('shipping', array('class'=>'form-control',));
		echo $this->Form->input('total', array('class'=>'form-control',));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="col-lg-3 actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Orders'), array('action' => 'index')); ?></li>
	</ul>
</div>
