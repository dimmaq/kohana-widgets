<div>
	<h2>Блоки&nbsp;&nbsp;[&nbsp;<?php echo HTML::anchor(_ar('widget','item', 'add'), 'добавить'); ?>&nbsp;]</h2>

	<ul>
		<?php
			foreach($items as $val)
			{
				echo '<li>#', $val['id'], ' ', HTML::anchor(_ar('widget','item', 'edit', $val['id']), $val['name']), '</li>';
			}
		?>
	</ul>
