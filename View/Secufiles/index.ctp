<div class="secufiles index">
	<h2><?php echo __('Secufiles'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('hash'); ?></th>
			<th><?php echo $this->Paginator->sort('content'); ?></th>
			<th><?php echo $this->Paginator->sort('remaining_views'); ?></th>
			<th><?php echo $this->Paginator->sort('is_img'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($secufiles as $secufile): ?>
	<tr>
		<td><?php echo h($secufile['Secufile']['id']); ?>&nbsp;</td>
		<td><?php echo h($secufile['Secufile']['hash']); ?>&nbsp;</td>
		<td><?php echo h($secufile['Secufile']['content']); ?>&nbsp;</td>
		<td><?php echo h($secufile['Secufile']['remaining_views']); ?>&nbsp;</td>
		<td><?php echo h($secufile['Secufile']['is_img']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $secufile['Secufile']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $secufile['Secufile']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $secufile['Secufile']['id']), array(), __('Are you sure you want to delete # %s?', $secufile['Secufile']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Secufile'), array('action' => 'add')); ?></li>
	</ul>
</div>
