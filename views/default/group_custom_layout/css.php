<?php ?>

#group_layout_editpanel table.draggable_group_widget {
	width:200px;
	background: #cccccc;
	margin: 10px 0 0 0;
	vertical-align:text-top;
	border:1px solid #cccccc;
}

#group_layout_editpanel table.draggable_group_widget h3 {
	word-wrap:break-word;/* safari, webkit, ie */
	width:140px;
	line-height: 1.1em;
	overflow: hidden;/* ff */
	padding:4px;
}

#group_layout_editpanel img.more_info {
	background: url(<?php echo $vars['url']; ?>_graphics/icon_customise_info.gif) no-repeat top left;
	cursor:pointer;
}
#group_layout_editpanel img.drag_handle {
	background: url(<?php echo $vars['url']; ?>_graphics/icon_customise_drag.gif) no-repeat top left;
	cursor:move;
}
#group_layout_editpanel img {
	margin-top:4px;
}

#group_layout_editpanel #rightcolumn_widgets {
	background: #DEDEDE;
}

#colorpicker_container {
	display: none;
	width: 100%;
}

#background_container {
	display: none;
}

#colorpicker_container label{
	text-align: center;
	display: block;
}

.farbtastic {
	margin: 0 auto;
}

a.thickbox {
	display: none;
}

#leftcolumn_widgets a.thickbox,
#middlecolumn_widgets a.thickbox {
	display: block;
}

.group_custom_layout_widget_settings{
	display:none;
}
