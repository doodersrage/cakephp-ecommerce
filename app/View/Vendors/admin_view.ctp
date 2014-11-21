<div class="vendors view">
<h2><?php echo __('Vendor'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($vendor['Vendor']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($vendor['Vendor']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('ContactName'); ?></dt>
		<dd>
			<?php echo h($vendor['Vendor']['contactName']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Telephone'); ?></dt>
		<dd>
			<?php echo h($vendor['Vendor']['telephone']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fax'); ?></dt>
		<dd>
			<?php echo h($vendor['Vendor']['fax']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Address'); ?></dt>
		<dd>
			<?php echo h($vendor['Vendor']['address']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Address2'); ?></dt>
		<dd>
			<?php echo h($vendor['Vendor']['address2']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('City'); ?></dt>
		<dd>
			<?php echo h($vendor['Vendor']['city']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('State'); ?></dt>
		<dd>
			<?php echo h($vendor['Vendor']['state']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('PostalCode'); ?></dt>
		<dd>
			<?php echo h($vendor['Vendor']['postalCode']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Vendor'), array('action' => 'edit', $vendor['Vendor']['id']),array('class'=>'btn btn-primary')); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Vendor'), array('action' => 'delete', $vendor['Vendor']['id']), array(), __('Are you sure you want to delete # %s?', $vendor['Vendor']['id']),array('class'=>'btn btn-primary')); ?> </li>
		<li><?php echo $this->Html->link(__('List Vendors'), array('action' => 'index'),array('class'=>'btn btn-primary')); ?> </li>
		<li><?php echo $this->Html->link(__('New Vendor'), array('action' => 'add'),array('class'=>'btn btn-primary')); ?> </li>
	</ul>
</div>
