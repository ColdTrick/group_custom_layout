<?php
 
	define("GROUP_CUSTOM_LAYOUT_SUBTYPE", 		"custom_layout");
	define("GROUP_CUSTOM_LAYOUT_BACKGROUND", 	"group_background");
	define("GROUP_CUSTOM_LAYOUT_RELATION", 		"custom_layout_relation");

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

		// register hooks
		elgg_register_plugin_hook_handler("view", "groups/profile/widgets", "group_custom_layout_widgets");

		// register actions
		elgg_register_action("group_custom_layout/save", dirname(__FILE__) . "/actions/save.php");
		elgg_register_action("group_custom_layout/reset", dirname(__FILE__) . "/actions/reset.php");
	}

	function group_custom_layout_page_handler($page) {
		
		switch($page[0]){
			case "get_background":
				if(!empty($page[1])) {
					$result = true;
					set_input("group_guid", $page[1]);
					
					include(dirname(__FILE__) . "/procedures/get_background.php");
				}
				break;
			default:
				if(!empty($page[0])) {
					set_input("group_guid", $page[0]);
				}
		   		include(dirname(__FILE__) . "/pages/edit.php");
		   		break;
		}
		
		return true;
	}

	function group_custom_layout_pagesetup() {
		
		$group = elgg_get_page_owner_entity();

		if (!empty($group) && elgg_instanceof($group, "group") && elgg_in_context("group_profile")) {
			if (group_custom_layout_allow($group)) {
				if ($group->canEdit()) {
					$item = array(
						"name" => "group_layout", 
						"text" => elgg_echo("group_custom_layout:edit"), 
						"href" => "group_custom_layout/" . $group->getGUID(), 
					);

					elgg_register_menu_item("page", $item);
				}
			}
		}
	}

	function group_custom_layout_allow(ElggGroup $group) {
		static $metadata_field;
		static $metadata_value;
		
		$result = false;

		if(!empty($group) && elgg_instanceof($group, "group")){
			
			// set statics
			if(!isset($metadata_field) && !isset($metadata_value)){
				$metadata_field = false;
				$metadata_value = false;
				
				// get metadata name
				if($field_setting = elgg_get_plugin_setting("metadata_key", "group_custom_layout")){
					$metadata_field = $field_setting;
				}
				
				// get metadata valeu
				if($value_setting = elgg_get_plugin_setting("metadata_value", "group_custom_layout")){
					$metadata_value = $value_setting;
				}
			}
			
			// check for this group
			if(!empty($metadata_field) && !empty($metadata_value)) {
				if(!empty($group->$metadata_field) && ($group->$metadata_field == $metadata_value)) {
					$result = true;
				}
			}
		}

		return $result;
	}

	function group_custom_layout_widgets($hook, $type, $returnvalue, $params) {
		if($params["view"] == "groups/profile/widgets") {
			$group = elgg_get_page_owner_entity();

			if($group instanceof ElggGroup) {
				if(group_custom_layout_allow($group)) {
					$layout_count = $group->countEntitiesFromRelationship(GROUP_CUSTOM_LAYOUT_RELATION);
					
					if($layout_count > 0) {
						$layout = $group->getEntitiesFromRelationship(GROUP_CUSTOM_LAYOUT_RELATION, false, $layout_count);
						$layout = $layout[0];

						$custom_css = elgg_view("group_custom_layout/group/css", array("group" => $group, "layout" => $layout));

						return $custom_css . $returnvalue;
					}
				}
			}
		}
	}