<h3><?php echo __('Attributes'); ?></h3>
	<dl>
		<?php
		$selAttributes = unserialize($productType['ProductType']['attributes']);
		$selAttributes = $selAttributes[0];
		foreach($selAttributes as $attribute){
			echo $this->Form->input('attribute.'.$attribute, array('class'=>'form-control', 'label'=>$attributeTypes[$attribute]));
		}
		?>
	</dl>