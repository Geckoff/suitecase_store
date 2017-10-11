<?php
    if(isset($P['value']) && !empty($P['value']) && isset($P['title']) && !empty($P['title'])) {
    	if(!empty($P['parent'])) {
    		DB("INSERT INTO `".$Config['settings_element']."` (`id_setting`,`value`,`name`,`create`, `sort`) VALUES ('".$P['parent']."','".$P['value']."','".$P['title']."','".time()."', '1')");
    		$ID = mysql_insert_id();
    		DB("UPDATE `".$Config['settings_element']."` SET `sort`='".$ID."' WHERE `id`='".$ID."' LIMIT 1");
    		$error = 0;
    	}
    	else {
    	    if (isset($P['id'])) {
                $ID = $P['id']; 
                DB("UPDATE `".$Config['settings_element']."` SET `value`='".$P['value']."',`name`='".$P['title']."',`create`='".time()."' WHERE `id`='".$ID."' LIMIT 1");
            }
    		$error = 2;
    	}
    }
    else{
    	$error = 1;
    	$ID = 0;
    }
?>