<?php 
	
	action_gatekeeper();
	gatekeeper();
	group_gatekeeper();
	
	$group_guid = get_input("group_guid");
	
	if(!empty($group_guid) && ($group = get_entity($group_guid))){
		if($group instanceof ElggGroup){
			// Check if custom layout exists
			$layout_count = $group->countEntitiesFromRelationship(GROUP_CUSTOM_LAYOUT_RELATION);
			if($layout_count > 0){
				$layouts = $group->getEntitiesFromRelationship(GROUP_CUSTOM_LAYOUT_RELATION, false, $layout_count);
				
				foreach($layouts as $layout){
					// removing background image
					if(!empty($layout->background)){
						$bgf = new ElggFile();
						$bgf->owner_guid = $group->guid;
						
						$bgf->setFilename(GROUP_CUSTOM_LAYOUT_BACKGROUND);
						$bgf->delete();
					}
					
					// removing layout
					if(remove_entity_relationship($group->guid, GROUP_CUSTOM_LAYOUT_RELATION, $layout->guid)){
						$layout->delete();
						system_message(elgg_echo("group_custom_layout:action:reset:success"));
					} else {
						register_error(elgg_echo("group_custom_layout:action:reset:error:remove"));
					}
				}
			} else {
				register_error(elgg_echo("group_custom_layout:action:reset:error:no_custom"));
			}
		} else {
			register_error(elgg_echo("group_custom_layout:action:reset:error:no_group"));
		}
	} else {
		register_error(elgg_echo("group_custom_layout:action:reset:error:input"));
	}
	
	forward($_SERVER["HTTP_REFERER"]);
?>