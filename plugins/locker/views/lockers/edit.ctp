<div class="lockers form">
<?php echo $form->create('Locker');?>
	<fieldset>
 		<legend><?php __('Edit Locker');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('member_id');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Locker.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Locker.id'))); ?></li>
		<li><?php echo $html->link(__('List Lockers', true), array('action'=>'index'));?></li>
	</ul>
</div>
