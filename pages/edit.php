<?php

	gatekeeper();

	elgg_load_css('thickbox_css');
	elgg_load_css('farbtastic_css');

	elgg_load_js('thickbox_js');
	elgg_load_js('farbtastic_js');
	elgg_load_js('edit_js');

	$group_guid = get_input("group_guid");
	$group = get_entity($group_guid);

	if(group_custom_layout_allow($group)) {
		$title = elgg_echo("group_custom_layout:edit:title");	

		$params = array(
			'filter' => '',
			'title' => $title
		);

		elgg_set_context("groups");
		elgg_set_page_owner_guid($group_guid);

		$layout = null;
		if($group->countEntitiesFromRelationship(GROUP_CUSTOM_LAYOUT_RELATION) > 0) {
			$layout = $group->getEntitiesFromRelationship(GROUP_CUSTOM_LAYOUT_RELATION);
			$layout = $layout[0];
		}

		$params['content'] = elgg_view_form('group_custom_layout/save', 
								array('id' => 'editForm', 'enctype' => 'multipart/form-data'), 
								array('entity' => $group, 'group_custom_layout' => $layout)
							);

		$body = elgg_view_layout('content', $params);

		echo elgg_view_page($title, $body);

		return true;
	} else {
		forward(REFERER);
	}