<?php
 
	define('GROUP_CUSTOM_LAYOUT_SUBTYPE', 		'custom_layout');
	define('GROUP_CUSTOM_LAYOUT_BACKGROUND', 	'group_background');
	define('GROUP_CUSTOM_LAYOUT_RELATION', 		'custom_layout_relation');

	elgg_register_event_handler('init', 'system', 'group_custom_layout_init');
	elgg_register_event_handler('pagesetup', 'system', 'group_custom_layout_pagesetup');

	function group_custom_layout_init() {
		global $CONFIG;

		elgg_extend_view('css/elgg', 'group_custom_layout/css');

		elgg_register_js('thickbox_js', 	'mod/group_custom_layout/vendors/thickbox/thickbox-compressed.js');
		elgg_register_js('farbtastic_js', 	'mod/group_custom_layout/vendors/farbtastic/farbtastic.js');
		elgg_register_js('edit_js', 		'mod/group_custom_layout/views/default/js/js.js');

		elgg_register_css('thickbox_css', 	'mod/group_custom_layout/vendors/thickbox/thickbox.css');
		elgg_register_css('farbtastic_css',	'mod/group_custom_layout/vendors/farbtastic/farbtastic.css');	

		elgg_register_page_handler('group_custom_layout', 'group_custom_layout_page_handler');

		elgg_register_plugin_hook_handler('view', 'groups/profile/widgets', 'group_custom_layout_widgets');

		elgg_register_action('group_custom_layout/save', dirname(__FILE__) . '/actions/save.php');
		elgg_register_action('group_custom_layout/reset', dirname(__FILE__) . '/actions/reset.php');
	}

	function group_custom_layout_page_handler($page) {
		switch($page[0]){
			case 'get_background':
				if(!empty($page[1])) {
					set_input('group_guid', $page[1]);
					include(dirname(__FILE__) . '/procedures/get_background.php');
				}
				break;
			default:
				if(!empty($page[0])) {
					set_input('group_guid', $page[0]);
				}
		   		include(dirname(__FILE__) . '/pages/edit.php');
		   		break;
		}
	}

	function group_custom_layout_pagesetup() {
		global $CONFIG;

		$group = elgg_get_page_owner_entity();

		if ($group instanceof ElggGroup && elgg_get_context() == 'group_profile') {
			if (group_custom_layout_allow($group)) {
				if ($group->canEdit()) {
					$item = array('name' => elgg_echo('group_custom_layout:edit'), 
						'text' => elgg_echo('group_custom_layout:edit'), 
						'href' => $CONFIG->wwwroot . 'group_custom_layout/' . $group->getGUID(), 
						'context' => 'groups', 
						'section' => 'groupsactions'
					);

					elgg_register_menu_item('page', $item);
				}
			}
		}
	}

	function group_custom_layout_allow($group) {
		$result = false;

		$metadata_field = elgg_get_plugin_setting('metadata_key');
		$metadata_value = elgg_get_plugin_setting('metadata_value');

		if(!empty($metadata_field) && !empty($metadata_value) && !empty($group) && ($group instanceof ElggGroup)) {
			if(!empty($group->$metadata_field) && $group->$metadata_field == $metadata_value) {
				$result = true;
			}
		}

		return $result;
	}

	function group_custom_layout_widgets($hook, $type, $returnvalue, $params) {
		if($params['view'] == 'groups/profile/widgets') {
			$group = elgg_get_page_owner_entity();

			if($group instanceof ElggGroup) {
				if(group_custom_layout_allow($group)) {
					$layout_count = $group->countEntitiesFromRelationship(GROUP_CUSTOM_LAYOUT_RELATION);
					
					if($layout_count > 0) {
						$layout = $group->getEntitiesFromRelationship(GROUP_CUSTOM_LAYOUT_RELATION, false, $layout_count);
						$layout = $layout[0];

						$custom_css = elgg_view('group_custom_layout/group/css', array('group' => $group, 'layout' => $layout));

						return $custom_css . $returnvalue;
					}
				}
			}
		}
	}