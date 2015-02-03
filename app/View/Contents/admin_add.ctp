<div class="col-lg-9 col-md-9 contents form">
<?php echo $this->Form->create('Content', array('type'=>'file')); ?>
	<fieldset>
		<legend><?php echo __('Admin Add Page'); ?></legend>
	<?php
		echo $this->Form->input('sortOrder', array('label'=>'Sort Order', 'class'=>'form-control',));
		echo $this->Form->input('title', array('label'=>'Page Title', 'class'=>'form-control',));
		echo $this->Form->input('header', array('label'=>'Page Header', 'class'=>'form-control',));
		echo $this->Wysiwyg->input('content', array('label'=>'Page Content', 'class'=>'form-control', 'id'=>'content'));
		echo $this->Form->input('contactForm', array('label'=>'Display contact form?','class'=>'form-control',));
		echo $this->Form->input('pageImage', array('label'=>'Page Image', 'type' => 'file', 'class'=>'form-control',));
		?>
		<h3><?php echo __('Product Information'); ?></h3>
		<?php
		echo $this->Form->input('csvFile', array('label'=>'Products CSV', 'type' => 'file', 'class'=>'form-control',));
		echo $this->Form->input('vendorId', array('label'=>'Vendor', 'class'=>'form-control','options'=>$vendors));
		echo $this->Form->input('parentId', array('label'=>'Parent Page', 'class'=>'form-control','options'=>$contents));
		echo $this->Form->input('productListType', array('class'=>'form-control','options'=>$productTypes));
		?>
		<h3><?php echo __('SEO and Meta'); ?></h3>
		<?php
		echo $this->Form->input('sefURL', array('label'=>'Search Engne Friendly URL', 'class'=>'form-control',));
		echo $this->Form->input('titleTag', array('label'=>'Header Title', 'class'=>'form-control',));
		echo $this->Form->input('metaDescription', array('label'=>'Meta Description', 'class'=>'form-control',));

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

		<li><?php echo $this->Html->link(__('List Contents'), array('action' => 'index'), array('class'=>'btn btn-primary')); ?></li>
	</ul>
</div>
