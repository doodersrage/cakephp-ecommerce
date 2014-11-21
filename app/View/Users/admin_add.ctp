<div class="col-lg-9 users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Add User'); ?></legend>
	<?php
		echo $this->Form->input('email', array('class'=>'form-control'));
		echo $this->Form->input('username', array('class'=>'form-control'));
		echo $this->Form->input('password', array('class'=>'form-control'));
		echo $this->Form->input('role', array('class'=>'form-control',
            'options' => array('admin' => 'Admin', 'customer' => 'Customer')
        ));
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

		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?></li>
	</ul>
</div>
