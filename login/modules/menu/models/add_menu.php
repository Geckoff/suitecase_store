<?php
	if(isset($P['menu_name']) && !empty($P['menu_name'])){
		DB("INSERT INTO `".$Config['menu']."` (`title`, `chpu`) VALUES ('".$P['menu_name']."','".translit($P['menu_name'])."')");
		$error = 0;
	}
	else{
		$error = 1;
	}
?>
