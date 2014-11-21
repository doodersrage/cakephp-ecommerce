<div class="addresses view">
<h2><?php echo __('Address'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($address['Address']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('UserId'); ?></dt>
		<dd>
			<?php echo h($address['Address']['userId']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('FirstName'); ?></dt>
		<dd>
			<?php echo h($address['Address']['firstName']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('LastName'); ?></dt>
		<dd>
			<?php echo h($address['Address']['lastName']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Company'); ?></dt>
		<dd>
			<?php echo h($address['Address']['company']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Telephone'); ?></dt>
		<dd>
			<?php echo h($address['Address']['telephone']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fax'); ?></dt>
		<dd>
			<?php echo h($address['Address']['fax']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Address'); ?></dt>
		<dd>
			<?php echo h($address['Address']['address']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Address2'); ?></dt>
		<dd>
			<?php echo h($address['Address']['address2']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('City'); ?></dt>
		<dd>
			<?php echo h($address['Address']['city']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('State'); ?></dt>
		<dd>
			<?php echo h($address['Address']['state']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('PostalCode'); ?></dt>
		<dd>
			<?php echo h($address['Address']['postalCode']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Address'), array('action' => 'edit', $address['Address']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Address'), array('action' => 'delete', $address['Address']['id']), array(), __('Are you sure you want to delete # %s?', $address['Address']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Addresses'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Address'), array('action' => 'add')); ?> </li>
	</ul>
</div>
