<div class="col-lg-9 col-md-9 contents index">
	<h2><?php echo __('Pages'); ?></h2>
	<div class="table-responsive">
		<div class="status-block">
		</div>
	<table class="table table-striped">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('title'); ?></th>
			<th><?php echo $this->Paginator->sort('Sort Order'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($contents as $content): ?>
	<tr>
		<td><?php echo h($content['Content']['id']); ?>&nbsp;</td>
		<td><?php echo h($content['Content']['title']); ?>&nbsp;</td>
		<td><?php echo h($content['Content']['sortOrder']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $content['Content']['id']), array('class'=>'btn btn-primary')); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $content['Content']['id']), array('class'=>'btn btn-primary')); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $content['Content']['id']), array('class'=>'btn btn-primary'), __('Are you sure you want to delete # %s?', $content['Content']['id'])); ?>
			<?php if($content['Content']['csvFile']){ ?>
				<a href="javascript: void(0)" onClick="addProducts(<?php echo $content['Content']['id']; ?>)" class="btn btn-primary">Import Products</a>
				<a href="javascript: void(0)" onClick="deleteProducts(<?php echo $content['Content']['id']; ?>)" class="btn btn-primary">Delete Products</a>
			<?php } ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
	<script>
        var addProducts = function(idx)
        {                
            var r = confirm("Are you sure you want to import products from CSV?");
			if (r == true) {
	            var repl = confirm("Delete all existing products?");
				// perform ajax request
                jQuery.post('<?php echo Router::Url(array('controller' => 'contents','admin' => TRUE, 'action' => 'import_products'), TRUE); ?>',
                    { id: idx, replProds: repl }, function(response) {
                        alert(response);
                });
        	}
            return false;
        }
        var deleteProducts = function(idx)
        {                
            var r = confirm("Are you sure you want to delete products assigned to this page?");
			if (r == true) {
				// perform ajax request
                jQuery.post('<?php echo Router::Url(array('controller' => 'contents','admin' => TRUE, 'action' => 'delete_products'), TRUE); ?>',
                    { id: idx }, function(response) {
                        alert(response);
                });
        	}
            return false;
        }
	</script>
	</div>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<ul class="pager">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</ul>
</div>
<div class="col-lg-3 col-md-3 actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Content'), array('action' => 'add'), array('class'=>'btn btn-primary')); ?></li>
	</ul>
</div>
