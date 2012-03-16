<?php 

	action_gatekeeper();
	gatekeeper();
	group_gatekeeper();

	$group_guid = get_input('group_guid');

	if(!empty($group_guid) && ($group = get_entity($group_guid))){
		if($group instanceof ElggGroup){
			$layout_count = $group->countEntitiesFromRelationship(GROUP_CUSTOM_LAYOUT_RELATION);

			if($layout_count > 0){
				$layouts = $group->getEntitiesFromRelationship(GROUP_CUSTOM_LAYOUT_RELATION, false, $layout_count);

				foreach($layouts as $layout) {
					if(!empty($layout->background)){
						$bgf = new ElggFile();
						$bgf->owner_guid = $group->getGUID();

						$bgf->setFilename(GROUP_CUSTOM_LAYOUT_BACKGROUND);
						$bgf->delete();
					}

					if(remove_entity_relationship($group->getGUID(), GROUP_CUSTOM_LAYOUT_RELATION, $layout->getGUID())){
						$layout->delete();
						system_message(elgg_echo('group_custom_layout:action:reset:success'));
					} else {
						register_error(elgg_echo('group_custom_layout:action:reset:error:remove'));
					}
				}
			} else {
				register_error(elgg_echo('group_custom_layout:action:reset:error:no_custom'));
			}
		} else {
			register_error(elgg_echo('group_custom_layout:action:reset:error:no_group'));
		}
	} else {
		register_error(elgg_echo('group_custom_layout:action:reset:error:input'));
	}

	forward(REFERER);