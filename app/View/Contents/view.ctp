<div class="col-lg-9 col-md-9 contents view">
<h2><?php echo __('Content'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($content['Content']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Title'); ?></dt>
		<dd>
			<?php echo h($content['Content']['title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Content'); ?></dt>
		<dd>
			<?php echo h($content['Content']['content']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('PageImage'); ?></dt>
		<dd>
			<?php echo h($content['Content']['pageImage']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('CsvFile'); ?></dt>
		<dd>
			<?php echo h($content['Content']['csvFile']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('TitleTag'); ?></dt>
		<dd>
			<?php echo h($content['Content']['titleTag']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('MetaDescription'); ?></dt>
		<dd>
			<?php echo h($content['Content']['metaDescription']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('VendorId'); ?></dt>
		<dd>
			<?php echo h($content['Content']['vendorId']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('ParentId'); ?></dt>
		<dd>
			<?php echo h($content['Content']['parentId']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('ProductListType'); ?></dt>
		<dd>
			<?php echo h($content['Content']['productListType']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="col-lg-3 col-md-3 actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Content'), array('action' => 'edit', $content['Content']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Content'), array('action' => 'delete', $content['Content']['id']), array(), __('Are you sure you want to delete # %s?', $content['Content']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Contents'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Content'), array('action' => 'add')); ?> </li>
	</ul>
</div>
