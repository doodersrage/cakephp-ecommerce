<div class="col-lg-9 col-md-9 productTypes view">
<h2><?php echo __('Product Type'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($productType['ProductType']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Title'); ?></dt>
		<dd>
			<?php echo h($productType['ProductType']['title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Attributes'); ?></dt>
		<dd>
			<?php
			// convert serialized array to iterable integer array
			$attrArr = unserialize($productType['ProductType']['attributes']);
			// print available attributes
			echo '<table class="table table-striped">
					<tr>
						<th>Attribute</th><th>Combine in Popover</th>
					</tr>';
			foreach($attributes as $val){
				if(in_array($val['ProductAttributeType']['id'],$attrArr[0],true)){
					echo '<tr>
							<td>
								'.$val['ProductAttributeType']['title'].'
							</td>
							<td>
								'.(in_array($val['ProductAttributeType']['id'],$attrArr[1],true) ? 'true' : '').'
							</td>
						</tr>';
				}
			}
			echo '</table>';
			?>
		</dd>
	</dl>
</div>
<div class="col-lg-3 col-md-3 actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Product Type'), array('action' => 'edit', $productType['ProductType']['id']),array('class'=>'btn btn-primary')); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Product Type'), array('action' => 'delete', $productType['ProductType']['id']), array('class'=>'btn btn-primary'), __('Are you sure you want to delete # %s?', $productType['ProductType']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Product Types'), array('action' => 'index'),array('class'=>'btn btn-primary')); ?> </li>
		<li><?php echo $this->Html->link(__('New Product Type'), array('action' => 'add'),array('class'=>'btn btn-primary')); ?> </li>
	</ul>
</div>
