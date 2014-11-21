<div class="col-lg-9 productTypes form">
<?php echo $this->Form->create('ProductType'); ?>
	<fieldset>
		<legend><?php echo __('Admin Add Product Type'); ?></legend>
	<?php
		echo $this->Form->input('title', array('class'=>'form-control',));
		// print available attributes
		echo '<table class="table table-striped">
				<tr>
					<th>Attribute</th><th>Combine in Popover</th>
				</tr>';
		foreach($attributes as $val){
			echo '<tr>
					<td>
						<input type="checkbox" name="attributes[]" value="'.$val['ProductAttributeType']['id'].'"> '.$val['ProductAttributeType']['title'].'
					</td>
					<td>
						<input type="checkbox" name="attributesHide[]" value="'.$val['ProductAttributeType']['id'].'">
					</td>
				</tr>';
		}
		echo '</table>';
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

		<li><?php echo $this->Html->link(__('List Product Types'), array('action' => 'index'),array('class'=>'btn btn-primary')); ?></li>
	</ul>
</div>
