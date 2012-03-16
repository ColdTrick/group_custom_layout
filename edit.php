<?php 
	
	gatekeeper();
	
	// Get the group
	$group_guid = get_input("group_guid");
	$group = get_entity($group_guid);
	
	if(group_custom_layout_allow($group)){
		// Set correct context and owner
		set_context("groups");
		set_page_owner($group_guid);
		
		// See if this group has a Custom Layout
		$layout = null;
		if($group->countEntitiesFromRelationship(GROUP_CUSTOM_LAYOUT_RELATION) > 0){
			$layout = $group->getEntitiesFromRelationship(GROUP_CUSTOM_LAYOUT_RELATION);
			$layout = $layout[0];
		}
		
		// Building page elements
		$title = elgg_view_title(elgg_echo("group_custom_layout:edit:title"));
		
		$body = elgg_view("group_custom_layout/edit", array("entity" => $group, "group_custom_layout" => $layout));
		
		$page_data = $title . $body;
		
		// Showing page
		page_draw(elgg_echo("group_custom_layout:edit"), elgg_view_layout("two_column_left_sidebar", "", $page_data));
	} else {
		forward($_SERVER["HTTP_REFERER"]);
	}
	
?>