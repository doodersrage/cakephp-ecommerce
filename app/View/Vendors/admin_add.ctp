<div class="col-lg-9 vendors form">
<?php echo $this->Form->create('Vendor'); ?>
	<fieldset>
		<legend><?php echo __('Admin Add Vendor'); ?></legend>
	<?php
		echo $this->Form->input('name', array('class'=>'form-control'));
		echo $this->Form->input('contactName', array('class'=>'form-control'));
		echo $this->Form->input('telephone', array('class'=>'form-control'));
		echo $this->Form->input('fax', array('class'=>'form-control'));
		echo $this->Form->input('address', array('class'=>'form-control'));
		echo $this->Form->input('address2', array('class'=>'form-control'));
		echo $this->Form->input('city', array('class'=>'form-control'));
		echo $this->Form->input('state', array('class'=>'form-control'));
		echo $this->Form->input('postalCode', array('class'=>'form-control'));
	?>
	</fieldset><br>
<?php 
echo $this->Form->submit('Submit',array(
                              'class' => 'btn btn-lg btn-primary btn-block',
                              'div' => false));
echo $this->Form->end(); ?><br>

</div>
<div class="col-lg-3 actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Vendors'), array('action' => 'index'),array('class'=>'btn btn-primary')); ?></li>
	</ul>
</div>
