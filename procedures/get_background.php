<?php 
	global $CONFIG;
	
	$guid = (int) get_input("group_guid");
	
	if(!empty($guid) && ($group = get_entity($guid))){
		if($group instanceof ElggGroup){
			// Check if custom layout exists
			if($group->countEntitiesFromRelationship(GROUP_CUSTOM_LAYOUT_RELATION) > 0){
				$layout = $group->getEntitiesFromRelationship(GROUP_CUSTOM_LAYOUT_RELATION);
				$layout = $layout[0];
				
				// Check if background isset
				if(!empty($layout->enable_background) && ($layout->enable_background == "yes")){
					
					if(is_dir($CONFIG->dataroot . "group_custom_layout/backgrounds/")){
						$filename = $CONFIG->dataroot . "group_custom_layout/backgrounds/" . $group->getGUID() . ".jpg";
						
						if($etag = md5(serialize(filemtime($filename)))){
							header('Etag: '. $etag); 
							
							$request_etag = $_SERVER['HTTP_IF_NONE_MATCH'];
								
							if(!empty($request_etag) && ($request_etag == $etag)){
								header("HTTP/1.0 304 Not Modified");
				    			exit();
							}
						}
						
						if($background = file_get_contents($filename)){
							header("Content-type: image");
							header('Expires: ' . date('r', time() + 864000));
							header("Pragma: public");
							header("Cache-Control: public");
							header("Content-Length: " . strlen($background));
							
							echo $background;
						}
					}
				}
			}
		}
	}
	
?>