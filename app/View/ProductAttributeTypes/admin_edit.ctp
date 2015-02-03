<div class="col-lg-9 col-md-9 productAttributeTypes form">
<?php echo $this->Form->create('ProductAttributeType'); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit Product Attribute Type'); ?></legend>
	<?php
		echo $this->Form->input('id', array('hiddenField' => true));
		echo $this->Form->input('title', array('class'=>'form-control',));
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

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('ProductAttributeType.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('ProductAttributeType.id')),array('class'=>'btn btn-primary')); ?></li>
		<li><?php echo $this->Html->link(__('List Product Attribute Types'), array('action' => 'index'),array('class'=>'btn btn-primary')); ?></li>
	</ul>
</div>
