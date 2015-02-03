<div class="col-lg-9 col-md-9 productTypes form">
<?php echo $this->Form->create('ProductType'); ?>
	<fieldset>
		<legend><?php echo __('Admin Add Product Type'); ?></legend>
	<?php
		echo $this->Form->input('title', array('class'=>'form-control',));
		echo $this->Form->input('enforceQty', array('label'=>'Enforce Product Quanity Values','class'=>'form-control',));
		echo $this->Form->input('custDimension', array('label'=>'Allow Customer Dimension Entry?','class'=>'form-control',));
		echo $this->Form->input('dimensionType', array('class'=>'form-control','options'=>array('','square'=>'Square','linear'=>'Linear')));
		echo $this->Form->input('dimensionMeasurement', array('class'=>'form-control','options'=>array('','ft'=>'Feet','in'=>'Inches','mm'=>'Millimeter')));
		echo $this->Form->label('Tiered Pricing Columns');
		?>
        <table id="tieredPricing">
            <tbody>
                <tr style="background:#D3D3D3">
                    <th style="padding:5px;border-right:1px solid #FFFFFF">Max Value</th>
                    <th style="padding:5px;border-right:1px solid #FFFFFF">Column Text</th>
                    <th style="padding:5px"><a href="#" class="glyphicon-plus add-price">&nbsp;</a></th>
                </tr>
            </tbody>
        </table>
		<?
		echo $this->Form->label('Product Attribute Settings');
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
<div class="col-lg-3 col-md-3 ctions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Product Types'), array('action' => 'index'),array('class'=>'btn btn-primary')); ?></li>
	</ul>
</div>
