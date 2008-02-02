<div class="documents form">
<?php echo $form->create('Document');?>
	<fieldset>
 		<legend><?php __('Add Document');?></legend>
	<?php
		echo $form->input('description');
		echo $form->input('locker_id');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Documents', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Lockers', true), array('controller'=> 'lockers', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Locker', true), array('controller'=> 'lockers', 'action'=>'add')); ?> </li>
	</ul>
</div>
