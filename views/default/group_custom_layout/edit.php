<?php 
	
	$group = $vars["entity"];
	$layout = $vars['group_custom_layout'];
	
	// Hidden fields for administration
	$form_body = elgg_view("input/hidden", array("internalname" => "group_guid", "value" => $group->getGUID()));
	
	// Color selection
	$form_body .= "<h3 class='settings'>" . elgg_echo("group_custom_layout:edit:colors")  . "</h3>";
	
	// Enable colors?
	$form_body .= "<div>";
	$form_body .= elgg_echo("group_custom_layout:edit:colors:enable") . "&nbsp;";
	$form_body .= "<select id='enable_colors' name='enable_colors' onChange='checkColors();'>";
	if(!empty($layout->enable_colors) && $layout->enable_colors != "no"){
		$form_body .= "<option value='yes' selected='yes'>" . elgg_echo("option:yes") . "</option>";
		$form_body .= "<option value='no'>" . elgg_echo("option:no") . "</option>";
	} else {
		$form_body .= "<option value='yes'>" . elgg_echo("option:yes") . "</option>";
		$form_body .= "<option value='no' selected='yes'>" . elgg_echo("option:no") . "</option>";
	}
	$form_body .= "</select>";
	$form_body .= "</div>";
	
	// Color pickers
	$form_body .= "<table id='colorpicker_container'><tr><td>";
	$background_color = $layout->background_color;
	if(empty($background_color)) $background_color = "#123456";
	$form_body .= "<label for='backgroundcolor'>" . elgg_echo("group_custom_layout:edit:backgroundcolor") . "</label><div id='backgroundpicker'></div><input type='text' id='backgroundcolor' name='background_color' value='" . $background_color . "' />";
	$form_body .= "</td><td>";
	
	$border_color = $layout->border_color;
	if(empty($border_color)) $border_color = "#123456"; 
	$form_body .= "<label for='bordercolor'>" . elgg_echo("group_custom_layout:edit:bordercolor") . "</label><div id='borderpicker'></div><input type='text' id='bordercolor' name='border_color' value='" . $border_color . "' />";
	$form_body .= "</td><td>";
	
	$title_color = $layout->title_color;
	if(empty($title_color )) $title_color  = "#123456";
	
	$form_body .= "<label for='titlecolor'>" . elgg_echo("group_custom_layout:edit:titlecolor") . "</label><div id='titlepicker'></div><input type='text' id='titlecolor' name='title_color' value='" . $title_color . "' />";
	$form_body .= "</td></tr></table>"; 
	
	// Background image
	$form_body .= "<h3 class='settings'>" . elgg_echo("group_custom_layout:edit:background")  . "</h3>";
	
	// Enable background image?
	$form_body .= "<div>";
	$form_body .= elgg_echo("group_custom_layout:edit:background:enable") . "&nbsp;";
	$form_body .= "<select id='enable_background' name='enable_background' onChange='checkBackground();'>";
	if(!empty($layout->enable_background) && $layout->enable_background != "no"){
		$form_body .= "<option value='yes' selected='yes'>" . elgg_echo("option:yes") . "</option>";
		$form_body .= "<option value='no'>" . elgg_echo("option:no") . "</option>";
	} else {
		$form_body .= "<option value='yes'>" . elgg_echo("option:yes") . "</option>";
		$form_body .= "<option value='no' selected='yes'>" . elgg_echo("option:no") . "</option>";
	}
	$form_body .= "</select>";
	$form_body .= "</div>";
	
	// Build input field
	$form_body .= "<div id='background_container'>";
	$form_body .= "<br />";
	$form_body .= elgg_echo("group_custom_layout:edit:backgroundfile"); 
	$form_body .= "<br />";
	$form_body .= elgg_view("input/file", array("internalname" => "backgroundFile", "value" => ""));
	$form_body .= "</div>";
	
	// Buttons
	$form_body .= "<br />";
	$form_body .= elgg_view("input/submit", array("internalname" => "saveButton", "value" => elgg_echo("save")));
	
	$ts = time();
	$token = generate_action_token($ts);
	
	if(!empty($layout)){
		$form_body .= " " . elgg_view("input/button", array("internalname" => "resetButton", "value" => elgg_echo("group_custom_layout:edit:reset"), "type"=>"button", "js"=>"onclick='if(confirm(\"" . elgg_echo("group_custom_layout:edit:reset:confirm") . "\")) document.location.href = \"" . $vars["url"] . "action/group_custom_layout/reset?group_guid=" . $group->guid . "&__elgg_token=$token&__elgg_ts=$ts\"'"));
	}
	
	$form = elgg_view("input/form", array(
									"body" => $form_body,
									"enctype" => "multipart/form-data",
									"internalid" => "editForm",
									"action" => $vars["url"] . "action/group_custom_layout/save"
											));
	
	
?>
<div class="contentWrapper"> 
	<script type="text/javascript" src="<?php echo $vars["url"]; ?>mod/group_custom_layout/vendors/thickbox/thickbox-compressed.js"></script>
	<script type="text/javascript" src="<?php echo $vars["url"]; ?>mod/group_custom_layout/vendors/farbtastic/farbtastic.js"></script>
	
	<link rel="stylesheet" href="<?php echo $vars["url"]; ?>mod/group_custom_layout/vendors/farbtastic/farbtastic.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo $vars["url"]; ?>mod/group_custom_layout/vendors/thickbox/thickbox.css" type="text/css" />
	
	<script type="text/javascript" charset="utf-8">
		function checkColors(){
			var enable = $('#enable_colors').val();
			
			if(enable != "yes"){
				$('#colorpicker_container').hide();
			} else {
				$('#colorpicker_container').show();
			}
		}

		function checkBackground(){
			var enable = $('#enable_background').val();
			
			if(enable != "yes"){
				$('#background_container').hide();
			} else {
				$('#background_container').show();
			}
		}
		
		$(document).ready(function() {
			checkColors();
			checkBackground();
			
			$('#backgroundpicker').farbtastic('#backgroundcolor');
			$('#borderpicker').farbtastic('#bordercolor');
			$('#titlepicker').farbtastic('#titlecolor');

		});
	</script>
	<?php echo $form;?>
</div> 