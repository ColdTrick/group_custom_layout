<?php 

	$plugin = elgg_extract("entity", $vars);
	
	echo "<div>";
	echo elgg_echo("group_custom_style:settings:metadata_key");
	echo elgg_view("input/text", array("name" => "params[metadata_key]", "value" => $plugin->metadata_key));
	echo "</div>";
	
	echo "<div>";
	echo elgg_echo("group_custom_style:settings:metadata_value");
	echo elgg_view("input/text", array("name" => "params[metadata_value]", "value" => $plugin->metadata_value));
	echo "</div>";
