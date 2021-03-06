<script>
    var updateAttributes = function(idx)
    {                
		// perform ajax request
        jQuery.post('<?php echo Router::Url(array('controller' => 'products','admin' => TRUE, 'action' => 'product_attributes_ajax'), TRUE); ?>',
            { id: idx }, function(response) {
                $('.prodAttributes').html(response);
        });
    }
    $('#prodType').change(function(){
    	updateAttributes($(this).val());
    })
    $(function(){
    	updateAttributes($('#prodType').val());
    });
</script>
<div class="col-lg-9 col-md-9 products form">
<?php echo $this->Form->create('Product'); ?>
	<fieldset>
		<legend><?php echo __('Add Product'); ?></legend>
	<?php
		echo $this->Form->input('itemNumber', array('type' => 'text', 'class'=>'form-control'));
		echo $this->Form->input('price', array('class'=>'form-control'));
		echo $this->Form->input('quantity', array('class'=>'form-control',));
		echo $this->Form->input('minQty', array('class'=>'form-control',));
		echo $this->Form->input('prodType', array('id'=>'prodType' ,'class'=>'form-control',
            'options' => $productTypes
        ));
        echo $this->Form->input('contentId', array('class'=>'form-control',
            'options' => $contents
        ));
        echo $this->Form->input('fullLength', array('label'=>'Full Length','class'=>'form-control',));
        echo $this->Form->input('fullWidth', array('label'=>'Full Width','class'=>'form-control',));
	?>
	<div class="prodAttributes">
	</div>
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

		<li><?php echo $this->Html->link(__('List Products'), array('action' => 'index')); ?></li>
	</ul>
</div>
