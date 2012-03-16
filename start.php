<?php 
	define("GROUP_CUSTOM_LAYOUT_SUBTYPE", "custom_layout");
	define("GROUP_CUSTOM_LAYOUT_BACKGROUND", "group_background");
	define("GROUP_CUSTOM_LAYOUT_RELATION", "custom_layout_relation");
	
	function group_custom_layout_init(){
		global $CONFIG;
		
		// Extending css
		extend_view("css", "group_custom_layout/css");
		
		// Register page handler
		register_page_handler('group_custom_layout', 'group_custom_layout_page_handler');
	}
	
	function group_custom_layout_page_handler($page){
		
		switch($page[0]){
			case "get_background":
				if(!empty($page[1])){
					set_input("group_guid", $page[1]);
					include(dirname(__FILE__) . "/procedures/get_background.php");
				}
				break;
			default:
				if(!empty($page[0])){
					set_input('group_guid', $page[0]);
				}
		   		include(dirname(__FILE__) . "/edit.php");
		   		break;
		}
	}
	
	function group_custom_layout_pagesetup(){
		global $CONFIG;
		
		$group = page_owner_entity();
		
		// Submenu items for all group pages
		if ($group instanceof ElggGroup && get_context() == 'groups') {
			if (group_custom_layout_allow($group)) {
				if ($group->canEdit()) {
					add_submenu_item(elgg_echo('group_custom_layout:edit'), $CONFIG->wwwroot . "pg/group_custom_layout/" . $group->getGUID(), '0groupsactions');
				}
			}
		}
	}
	
	function group_custom_layout_allow($group){
		$result = false;
		
		$metadata_field = get_plugin_setting("metadata_key");
		$metadata_value = get_plugin_setting("metadata_value");
		
		if(!empty($metadata_field) && !empty($metadata_value) && !empty($group) && ($group instanceof ElggGroup)){
			if(!empty($group->$metadata_field) && $group->$metadata_field == $metadata_value){
				$result = true;
			}
		}
		
		return $result;
	}
	
	function group_custom_layout_widgets($hook, $type, $returnvalue, $params){
		if(!empty($params) && is_array($params) && array_key_exists("view", $params)){
			if($params["view"] == "groups/profileitems"){
				$group = page_owner_entity();
				
				if($group instanceof ElggGroup){
					if(group_custom_layout_allow($group)){
						$layout_count = $group->countEntitiesFromRelationship(GROUP_CUSTOM_LAYOUT_RELATION);
						if($layout_count > 0){
							$layout = $group->getEntitiesFromRelationship(GROUP_CUSTOM_LAYOUT_RELATION, false, $layout_count);
							$layout = $layout[0];
							
							$custom_css = elgg_view("group_custom_layout/group/css", array("group" => $group, "layout" => $layout));
							
							return $custom_css . $returnvalue;
						}
					}
				}
			}
		}
	}

	// Default event handlers for plugin functionality
	register_elgg_event_handler('init', 'system', 'group_custom_layout_init');
	register_elgg_event_handler('pagesetup', 'system', 'group_custom_layout_pagesetup');
	
	// Register plugin hooks
	register_plugin_hook("display", "view", "group_custom_layout_widgets");
	
	// Register actions
	register_action("group_custom_layout/save", false, dirname(__FILE__) . "/actions/save.php");
	register_action("group_custom_layout/reset", false, dirname(__FILE__) . "/actions/reset.php");
?>