<li class="locker">
	<?php
		echo $html->link(
			__d('locker','Locker', true),
			array(
				'plugin'		=>'locker',
				'controller'	=> 'folders',
				'action'		=> 'view',
				'member_id'		=> $data['member_id']
			)
		);
	?>
</li>