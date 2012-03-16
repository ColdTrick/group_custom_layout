<?php 

	global $CONFIG;

	action_gatekeeper();
	gatekeeper();
	group_gatekeeper();
	
	$group_guid = (int) get_input("group_guid");
	
	if(!empty($group_guid) && ($group = get_entity($group_guid))){
		if($group instanceof ElggGroup){
			// Check if custom layout allready exists
			$existing = false;
			if($group->countEntitiesFromRelationship(GROUP_CUSTOM_LAYOUT_RELATION) > 0){
				$layout = $group->getEntitiesFromRelationship(GROUP_CUSTOM_LAYOUT_RELATION);
				$layout = $layout[0];
				$existing = true;
			} else {
				$layout = new ElggObject();
				$layout->subtype = GROUP_CUSTOM_LAYOUT_SUBTYPE;
				$layout->owner_guid = $group->getGUID();
				$layout->container_guid = $group->getGUID();
				$layout->access_id = ACCESS_PUBLIC;
				
				$layout->save();
			}
			
			// adding background
			$enable_background = get_input("enable_background", "no");
			$layout->enable_background = $enable_background;
			
			if($enable_background == "yes"){
				if($file_contents = get_uploaded_file("backgroundFile")){
					$background = $_FILES["backgroundFile"];
					
					if(stristr($background["type"], "image")){
						
						if(!is_dir($CONFIG->dataroot . "group_custom_layout/")){
							mkdir($CONFIG->dataroot . "group_custom_layout/");
						}
						
						if(!is_dir($CONFIG->dataroot . "group_custom_layout/backgrounds/")){
							mkdir($CONFIG->dataroot . "group_custom_layout/backgrounds/");
						}
						
						if(file_put_contents($CONFIG->dataroot . "group_custom_layout/backgrounds/" . $group->getGUID() . ".jpg", $file_contents)){
							system_message(elgg_echo("group_custom_layout:action:save:success:background"));
						}
					} else {
						register_error(elgg_echo("group_custom_layout:action:save:error:background"));
					}
				}
			} else {
				if(file_exists($CONFIG->dataroot . "group_custom_layout/backgrounds/" . $group->getGUID() . ".jpg")){
					unlink($CONFIG->dataroot . "group_custom_layout/backgrounds/" . $group->getGUID() . ".jpg");
				}
			}
			
			$layout->save();
			
			// adding colors
			$enable_colors = get_input("enable_colors", "no");
			$layout->enable_colors = $enable_colors;
			
			if($enable_colors == "yes"){
				$background_color = get_input("background_color");
				$border_color = get_input("border_color");
				$title_color = get_input("title_color");
				
				if(!empty($background_color)){
					$layout->background_color = $background_color;
					system_message(elgg_echo("group_custom_layout:action:save:success:background_color"));
				} else {
					register_error(elgg_echo("group_custom_layout:action:save:error:background_color"));
				}
				
				if(!empty($border_color)){
					$layout->border_color = $border_color;
					system_message(elgg_echo("group_custom_layout:action:save:success:border_color"));
				} else {
					register_error(elgg_echo("group_custom_layout:action:save:error:border_color"));
				}
				
				if(!empty($title_color)){
					$layout->title_color = $title_color;
					system_message(elgg_echo("group_custom_layout:action:save:success:title_color"));
				} else {
					register_error(elgg_echo("group_custom_layout:action:save:error:title_color"));
				}
			}
			
			// Last save
			$last_save = $layout->save();
			
			// Add layout to group
			if($existing && $last_save){
				system_message(elgg_echo("group_custom_layout:action:save:success:existing"));
			} elseif($existing && !$last_save){
				register_error(elgg_echo("group_custom_layout:action:save:error:last_save"));
			} elseif(!$existing && $group->addRelationship($layout->getGUID(), GROUP_CUSTOM_LAYOUT_RELATION)){
				system_message(elgg_echo("group_custom_layout:action:save:success:group"));
			} else {
				register_error(elgg_echo("group_custom_layout:action:save:error:add_to_group"));
			}
		} else {
			register_error(elgg_echo("group_custom_layout:action:save:error:no_group"));
		}
	} else {
		register_error(elgg_echo("group_custom_layout:action:save:error:input"));
	}

	forward($CONFIG->wwwroot . "pg/groups/" . $group->getGUID());
?>