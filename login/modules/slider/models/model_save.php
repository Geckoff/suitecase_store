<?php
	$_IMAGE = DB("SELECT `id`,`image` FROM ".$Config['slider']." WHERE `id` = ".$P['id']." AND `parent`='".$P['parent']."' AND `delete`=0 LIMIT 1");
	if(isset($_IMAGE[0]['image'])&&!empty($_IMAGE[0]['image'])){
		if(isset($_POST['image'])&&!empty($_POST['image'])){
			unlinkImage($_IMAGE[0]['image']);
			saveImage($_POST['image']);
			DB("UPDATE `".$Config['slider']."` SET `title` ='".$P['title']."', `description`='".$P['description']."', `url`='".$P['url']."', `image` = '".$_POST['image']."' WHERE `id`='".$P['id']."' AND `parent`='".$P['parent']."'");
		}
		DB("UPDATE `".$Config['slider']."` SET `title` ='".$P['title']."', `description`='".$P['description']."', `url`='".$P['url']."' WHERE `id`='".$P['id']."' AND `parent`='".$P['parent']."'");
		$_last_id = $P['id'];
	}
	else{
		if(isset($_POST['image'])&&!empty($_POST['image'])){
			saveImage($_POST['image']);
			$_sort_max = DB("SELECT MAX(sort) AS `sort` FROM ".$Config['slider']);
			DB("INSERT INTO `".$Config['slider']."` (`parent`, `sort`, `title`, `description`, `url`, `image`) VALUES ('".$P['parent']."', '".($_sort_max[0]['sort']!='' ? (int)($_sort_max[0]['sort']+1) : 1)."', '".$P['title']."', '".$P['description']."', '".$P['url']."', '".$_POST['image']."')");
			$_last_id = mysql_insert_id();
		}
		else{
			$error = 2;
		}
	}
?>
