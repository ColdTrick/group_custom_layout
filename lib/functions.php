<?php

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
	
	function group_custom_layout_get_layout(ElggGroup $group){
		$result = false;
		
		if(!empty($group) && elgg_instanceof($group, "group")){
			if(group_custom_layout_allow($group)){
				if($layouts = $group->getEntitiesFromRelationship(GROUP_CUSTOM_LAYOUT_RELATION)){
					$result = $layouts[0];
				}
			}
		}
		
		return $result;
	}