<div class="orders view">
<h2><?php echo __('Order'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($order['Order']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('ShipAddressId'); ?></dt>
		<dd>
			<?php echo h($order['Order']['shipAddressId']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('BillAddressId'); ?></dt>
		<dd>
			<?php echo h($order['Order']['billAddressId']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('SubTotal'); ?></dt>
		<dd>
			<?php echo h($order['Order']['subTotal']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Tax'); ?></dt>
		<dd>
			<?php echo h($order['Order']['tax']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Shipping'); ?></dt>
		<dd>
			<?php echo h($order['Order']['shipping']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Total'); ?></dt>
		<dd>
			<?php echo h($order['Order']['total']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Order'), array('action' => 'edit', $order['Order']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Order'), array('action' => 'delete', $order['Order']['id']), array(), __('Are you sure you want to delete # %s?', $order['Order']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Orders'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Order'), array('action' => 'add')); ?> </li>
	</ul>
</div>
