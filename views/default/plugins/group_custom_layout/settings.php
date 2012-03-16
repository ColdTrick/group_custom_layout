<?php 

?>
<div>
	<?php echo elgg_echo("group_custom_style:settings:metadata_key"); ?><br />
	<input type="text" value="<?php echo $vars["entity"]->metadata_key; ?>" name="params[metadata_key]"><br />
	<?php echo elgg_echo("group_custom_style:settings:metadata_value"); ?><br />
	<input type="text" value="<?php echo $vars["entity"]->metadata_value; ?>" name="params[metadata_value]"><br />
</div>