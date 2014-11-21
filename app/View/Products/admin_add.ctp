<div class="col-lg-9 products form">
<?php echo $this->Form->create('Product'); ?>
	<fieldset>
		<legend><?php echo __('Add Product'); ?></legend>
	<?php
		echo $this->Form->input('price', array('class'=>'form-control'));
		echo $this->Form->input('quantity', array('class'=>'form-control',));
		echo $this->Form->input('prodType', array('class'=>'form-control',
            'options' => $productTypes
        ));
        echo $this->Form->input('contentId', array('class'=>'form-control',
            'options' => $contents
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

		<li><?php echo $this->Html->link(__('List Products'), array('action' => 'index')); ?></li>
	</ul>
</div>