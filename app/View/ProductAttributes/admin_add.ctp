<div class="col-lg-9 col-md-9 productAttributes form">
<?php echo $this->Form->create('ProductAttribute'); ?>
	<fieldset>
		<legend><?php echo __('Add Product Attribute'); ?></legend>
	<?php
		echo $this->Form->input('attributeId', array('class'=>'form-control',));
		echo $this->Form->input('itemNumber', array('class'=>'form-control',));
		echo $this->Form->input('content', array('class'=>'form-control',));
	?>
	</fieldset><br>
<?php 
echo $this->Form->submit('Submit',array(
                              'class' => 'btn btn-lg btn-primary btn-block',
                              'div' => false));
echo $this->Form->end(); ?><br>
</div>
<div class="col-lg-3 col-md-3 actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Product Attributes'), array('action' => 'index')); ?></li>
	</ul>
</div>
