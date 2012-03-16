<?php 
	$group = $vars["group"];
	$layout = $vars["layout"];
	
?>
<style type="text/css">
	<?php if(!empty($layout->enable_background) && $layout->enable_background == "yes"){ ?>
		#page_container {
			background-image: url(<?php echo $vars["url"]; ?>pg/group_custom_layout/get_background/<?php echo $group->getGUID(); ?>);
		}
	<?php } ?>
	
	<?php 
		if(!empty($layout->enable_colors) && $layout->enable_colors == "yes"){ 
			if(is_plugin_enabled("widget_manager") && (get_plugin_setting("group_enable", "widget_manager") == "yes") && $group->widget_manager_enable == "yes"){
		?>		
		#widget_table .collapsable_box_header {
			border: 1px solid <?php echo $layout->border_color; ?>;
			background: <?php echo $layout->background_color; ?>; 
		}
		
		#widget_table .collapsable_box_content {
			border-left: 1px solid <?php echo $layout->border_color; ?>; 
			border-bottom: 1px solid <?php echo $layout->border_color; ?>; 
			border-right: 1px solid <?php echo $layout->border_color; ?>;
			background: <?php echo $layout->background_color; ?>;
		}
		
		#widget_table .collapsable_box_header h1,
		#widget_table .collapsable_box_header h1 a {
			color: <?php echo $layout->title_color; ?>;
		}
				
		<?php	
			} else {
		?>
		#group_pages_widget,
		#izap_widget_layout,
		#tidypics_group_profile,
		#filerepo_widget_layout,
		#fullcolumn .contentWrapper,
		#left_column .group_widget,
		#right_column .group_widget  {
			background: <?php echo $layout->background_color; ?>;
			border: 1px solid <?php echo $layout->border_color; ?>; 
		}
		
		#two_column_left_sidebar_maincontent h1,
		#two_column_left_sidebar_maincontent h1 a,
		#two_column_left_sidebar_maincontent h2,
		#two_column_left_sidebar_maincontent h2 a,
		#two_column_left_sidebar_maincontent h3,
		#two_column_left_sidebar_maincontent h3 a,
		#two_column_left_sidebar_maincontent h4, 
		#two_column_left_sidebar_maincontent h4 a{
			color: <?php echo $layout->title_color; ?>;
		}
		
	<?php 
		}
	} ?>
</style>