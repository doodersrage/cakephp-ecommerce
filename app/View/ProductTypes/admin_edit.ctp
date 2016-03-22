<div class="col-lg-9 col-md-9 productTypes form">
<?php echo $this->Form->create('ProductType'); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit Product Type'); ?></legend>
	<?php
		echo $this->Form->input('id', array('hiddenField' => true));
		echo $this->Form->input('title', array('class'=>'form-control',));
		echo $this->Form->input('minPurchasePrice', array('label'=>'Minimum Purchase Price','class'=>'form-control',));
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
        <script>
		// load existing tiered pricing data
		<?php
		echo 'tieredPrices = ' . json_encode($tieredPricing);
		?>
		</script>
        <?php
		echo $this->Form->label('Product Attribute Settings');
		// print available attributes
		$attrArr = unserialize($this->request->data['ProductType']['attributes']);
		echo '<table class="table table-striped">
				<tr>
					<th>Attribute</th><th>Combine in Popover</th><th>Sort Order</th>
				</tr>';
		foreach($attributes as $val){
			echo '<tr>
					<td>
						<input type="checkbox" name="attributes[]" value="'.$val['ProductAttributeType']['id'].'"'.(is_array($attrArr[0]) ? (in_array($val['ProductAttributeType']['id'],$attrArr[0],true) ? ' checked="checked" ' : '') : '').'> '.$val['ProductAttributeType']['title'].'
					</td>
					<td>
						<input type="checkbox" name="attributesHide[]" value="'.$val['ProductAttributeType']['id'].'"'.(is_array($attrArr[1]) ? (in_array($val['ProductAttributeType']['id'],$attrArr[1],true) ? ' checked="checked" ' : '') : '').'>
					</td>
					<td>
						<input type="text" name="attributesSort['.$val['ProductAttributeType']['id'].']" value="'.(!empty($attrArr[2]) ? (is_array($attrArr[2]) ? (!empty($attrArr[2][$val['ProductAttributeType']['id']]) ? $attrArr[2][$val['ProductAttributeType']['id']] : 0) : 0) : 0).'" >
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
<div class="col-lg-3 col-md-3 actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('ProductType.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('ProductType.id')),array('class'=>'btn btn-primary')); ?></li>
		<li><?php echo $this->Html->link(__('List Product Types'), array('action' => 'index'),array('class'=>'btn btn-primary')); ?></li>
	</ul>
</div>
