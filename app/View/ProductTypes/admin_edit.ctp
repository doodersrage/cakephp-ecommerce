<div class="col-lg-9 productTypes form">
<?php echo $this->Form->create('ProductType'); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit Product Type'); ?></legend>
	<?php
		echo $this->Form->input('id', array('hiddenField' => true));
		echo $this->Form->input('title', array('class'=>'form-control',));
		// print available attributes
		$attrArr = unserialize($this->request->data['ProductType']['attributes']);
		echo '<table class="table table-striped">
				<tr>
					<th>Attribute</th><th>Combine in Popover</th>
				</tr>';
		foreach($attributes as $val){
			echo '<tr>
					<td>
					<input type="checkbox" name="attributes[]" value="'.$val['ProductAttributeType']['id'].'"'.(in_array($val['ProductAttributeType']['id'],$attrArr[0],true) ? ' checked="checked" ' : '').'> '.$val['ProductAttributeType']['title'].'
					</td>
					<td>
					<input type="checkbox" name="attributesHide[]" value="'.$val['ProductAttributeType']['id'].'"'.(in_array($val['ProductAttributeType']['id'],$attrArr[1],true) ? ' checked="checked" ' : '').'>
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

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('ProductType.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('ProductType.id')),array('class'=>'btn btn-primary')); ?></li>
		<li><?php echo $this->Html->link(__('List Product Types'), array('action' => 'index'),array('class'=>'btn btn-primary')); ?></li>
	</ul>
</div>
