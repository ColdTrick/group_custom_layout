<?php
 
	define("GROUP_CUSTOM_LAYOUT_SUBTYPE", 		"custom_layout");
	define("GROUP_CUSTOM_LAYOUT_BACKGROUND", 	"group_background");
	define("GROUP_CUSTOM_LAYOUT_RELATION", 		"custom_layout_relation");

	require_once(dirname(__FILE__) . "/lib/functions.php");
	require_once(dirname(__FILE__) . "/lib/page_handlers.php");
	
	elgg_register_event_handler("init", "system", "group_custom_layout_init");
	elgg_register_event_handler("pagesetup", "system", "group_custom_layout_pagesetup");
	
	function group_custom_layout_init() {
		// extend css/js
		elgg_extend_view("css/elgg", "group_custom_layout/css");
		elgg_extend_view("js/elgg", "group_custom_layout/js/site");

		// register external JS libraries
		elgg_register_js("thickbox_js", 	"mod/group_custom_layout/vendors/thickbox/thickbox-compressed.js");
		elgg_register_js("farbtastic_js", 	"mod/group_custom_layout/vendors/farbtastic/farbtastic.js");
		
		// register external CSS
		elgg_register_css("thickbox_css", 	"mod/group_custom_layout/vendors/thickbox/thickbox.css");
		elgg_register_css("farbtastic_css",	"mod/group_custom_layout/vendors/farbtastic/farbtastic.css");	

		// register page handler
		elgg_register_page_handler("group_custom_layout", "group_custom_layout_page_handler");

		// register actions
		elgg_register_action("group_custom_layout/save", dirname(__FILE__) . "/actions/save.php");
		elgg_register_action("group_custom_layout/reset", dirname(__FILE__) . "/actions/reset.php");
	}

	function group_custom_layout_pagesetup() {
		
		$group = elgg_get_page_owner_entity();

		if (!empty($group) && elgg_instanceof($group, "group")) {
			if (group_custom_layout_allow($group) && $group->canEdit()) {
				// add menu item for group admins to edit layout
				elgg_register_menu_item("page", array(
					"name" => "group_layout", 
					"text" => elgg_echo("group_custom_layout:edit"), 
					"href" => "group_custom_layout/" . $group->getGUID(),
					"context" => "group_profile"
				));
			}
			
			if($layout = group_custom_layout_get_layout($group)){
				elgg_register_css("custom_group_layout", "group_custom_layout/group_css/" . $layout->getGUID() . "/" . $layout->time_updated . ".css");
				elgg_load_css("custom_group_layout");
			}
		}
	}
