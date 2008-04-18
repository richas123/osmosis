<div class="forums form">
<?php echo $form->create('Forum');?>
	<fieldset>
 		<legend><?php __('Add Forum');?></legend>
	<?php
		echo $form->input('course_id');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Forums', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Courses', true), array('controller'=> 'courses', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Course', true), array('controller'=> 'courses', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Subjects', true), array('controller'=> 'subjects', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Subject', true), array('controller'=> 'subjects', 'action'=>'add')); ?> </li>
	</ul>
</div>