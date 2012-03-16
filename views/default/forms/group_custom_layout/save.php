<?php

	$group = $vars['entity'];
	$layout = $vars['group_custom_layout'];
	
	echo elgg_view('input/hidden', array('name' => 'group_guid', 'value' => $group->getGUID()));
	?>
	<label><?php echo elgg_echo('group_custom_layout:edit:colors'); ?></label>
	<div>
	<?php 
		echo elgg_echo('group_custom_layout:edit:colors:enable') . '&nbsp;'; 
		$yesno_options = array(
			'yes' => elgg_echo('option:yes'),
			'no' => elgg_echo('option:no')
		);
		
		if(!empty($layout->enable_colors) && $layout->enable_colors != 'no') {
			$enable_colors_value = 'yes';
		} else {
			$enable_colors_value = 'no';
		}
		
		echo elgg_view('input/dropdown', array('id' => 'enable_colors', 'name' => 'enable_colors', 'value' => $enable_colors_value, 'onChange' => 'checkColors();', 'options_values' => $yesno_options));
	?>
	</div>

	<table id="colorpicker_container">
		<tr>
			<td>
				<?php 
				$background_color = $layout->background_color;
				if(empty($background_color)) {
					$background_color = '#123456';
				}
				?>
				<label for="backgroundcolor"><?php echo elgg_echo('group_custom_layout:edit:backgroundcolor'); ?></label>
				<div id='backgroundpicker'></div>
				<?php echo elgg_view('input/text', array('id' => 'backgroundcolor', 'name' => 'background_color', 'value' => $background_color)); ?>
			</td>
			<td>
			<?php 
				$border_color = $layout->border_color;
				if(empty($border_color)) {
					$border_color = '#123456'; 
				}
				?>
				<label for="bordercolor"><?php echo elgg_echo('group_custom_layout:edit:bordercolor'); ?></label>
				<div id="borderpicker"></div>
				<?php echo elgg_view('input/text', array('id' => 'bordercolor', 'name' => 'border_color', 'value' => $border_color)); ?>
			</td>
			<td>
			<?php
				$title_color = $layout->title_color;
				if(empty($title_color )) {
					$title_color  = '#123456';
				}
				?>
				<label for="titlecolor"><?php echo elgg_echo('group_custom_layout:edit:titlecolor'); ?></label>
				<div id="titlepicker"></div>
				<?php echo elgg_view('input/text', array('id' => 'titlecolor', 'name' => 'title_color', 'value' => $title_color)); ?>
			</td>
		</tr>
	</table>
	  
	<label><?php echo elgg_echo('group_custom_layout:edit:background'); ?></label>
	<div>
		<?php 
		echo elgg_echo('group_custom_layout:edit:background:enable') . '&nbsp;';

		if(!empty($layout->enable_background) && $layout->enable_background != 'no') {
			$enable_background_value = 'yes';
		} else {
			$enable_background_value = 'no';
		}
		
		echo elgg_view('input/dropdown', array('id' => 'enable_background', 'name' => 'enable_background', 'value' => $enable_background_value, 'onChange' => 'checkBackground();', 'options_values' => $yesno_options));
		?>
	</div>
	
	<div id="background_container">
		<br />
		<?php echo elgg_echo('group_custom_layout:edit:backgroundfile'); ?> 
		<br />
		<?php echo elgg_view('input/file', array('name' => 'backgroundFile')); ?>
	</div>
	
	<br />
	<?php 
	echo elgg_view('input/submit', array('name' => 'saveButton', 'value' => elgg_echo('save')));
		
	if(!empty($layout)) {
		echo ' ' . elgg_view('input/button', array('name' => 'resetButton', 'value' => elgg_echo('group_custom_layout:edit:reset'), 'type' => 'button', 'js' => "onclick='if(confirm(\"" . elgg_echo("group_custom_layout:edit:reset:confirm") . "\")) document.location.href = \"" . elgg_add_action_tokens_to_url("action/group_custom_layout/reset?group_guid=" . $group->getGUID()) . "\"'"));
	}