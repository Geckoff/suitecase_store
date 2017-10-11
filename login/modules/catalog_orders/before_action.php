<?php
function set_new($arr){
	global $Config;
	foreach($arr as $id => $val){
		if($val == 1){
			DB("update `".$Config['catalog_orders']."` set `state` = '2' where `id` = ".$id);
		}
		else continue;
	}
}	
function set_unfinished($arr){
	global $Config;
	foreach($arr as $id => $val){
		if($val == 1){
			DB("update `".$Config['catalog_orders']."` set `state` = '0' where `id` = ".$id);
		}
		else continue;
	}
}	
function set_executed($arr){
	global $Config;
	foreach($arr as $id => $val){
		if($val == 1){
			DB("update `".$Config['catalog_orders']."` set `state` = '1' where `id` = ".$id);
		}
		else continue;
	}
}	
function set_cancelled($arr){
	global $Config;
	foreach($arr as $id => $val){
		if($val == 1){
			DB("update `".$Config['catalog_orders']."` set `state` = '-1' where `id` = ".$id);
		}
		else continue;
	}
}
// Рекурсия таблицы "catalog_tree" для получения полного URL категорий
$urlTree = array(); 
function getUrlTree($id_tree, $table, $newLoop = true){
	global $urlTree;
	if ($newLoop) {
		$urlTree = array();        
	}
	$res = DB("SELECT `id`, `title`, `id_tree`, `url` FROM `".$table."` WHERE `id` = '".$id_tree."' AND `active` = '1' AND `delete` = '0' LIMIT 1");
	if(isset($res[0]) && !empty($res[0])){
		foreach($res as $key => $value){
			$urlTree[] = $value;
			getUrlTree($value['id_tree'], $table, false);
		}
	}
	return $urlTree;
}
?>
