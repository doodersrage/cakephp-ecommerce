<div class="col-lg-9 addresses form">
<?php echo $this->Form->create('Address'); ?>
	<fieldset>
		<legend><?php echo __('Add Address'); ?></legend>
	<?php
		echo $this->Form->input('userId', array('class'=>'form-control',));
		echo $this->Form->input('firstName', array('class'=>'form-control',));
		echo $this->Form->input('lastName', array('class'=>'form-control',));
		echo $this->Form->input('company', array('class'=>'form-control',));
		echo $this->Form->input('telephone', array('class'=>'form-control',));
		echo $this->Form->input('fax', array('class'=>'form-control',));
		echo $this->Form->input('address', array('class'=>'form-control',));
		echo $this->Form->input('address2', array('class'=>'form-control',));
		echo $this->Form->input('city', array('class'=>'form-control',));
		echo $this->Form->input('state', array('class'=>'form-control',));
		echo $this->Form->input('postalCode', array('class'=>'form-control',));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="col-lg-3 actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Addresses'), array('action' => 'index')); ?></li>
	</ul>
</div>
