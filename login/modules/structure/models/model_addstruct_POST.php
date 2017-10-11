<?php
	$__MAX = DB("SELECT MAX(`sort`) AS `max_sort` FROM ".$Config['main_table']);
	DB("INSERT INTO `".$Config['main_table']."` 
		(
            `sort`, `parent`, `menu_title`, `title`, `name`, `url`, `text`,
            `meta_title`, `meta_keywords`, `meta_description`
        ) 
		VALUES
		(
            '".($__MAX[0]['max_sort'] + 1)."', '".$P['substruct']."', '".$P['menu_title']."', '".$P['title']."', '".translit($P['title'])."', '', '".$P['text']."',
            '".$P['meta_title']."', '".$P['meta_keywords']."', '".$P['meta_description']."'
        )");
	
	$_last_id = mysql_insert_id();

	$__SR = getRelation($_last_id);
	if (!isset($__SR[0])) {
		DB("INSERT INTO `".$Config['table_relations']."`
			(`id_struct`, `id_module`, `id_page`) 
			VALUES
			('".$_last_id."', '".$P['module'][-1]."', '0')");
	}
	else {
		DB("UPDATE `".$Config['table_relations']."` SET
			`id_module` = '".$P['module'][-1]."'
			WHERE `id_struct` = ".$_last_id);
	}
    
    $_last_id_page = $_last_id;
    
	$__SR = DB("SELECT `id` FROM `".$Config['table_relations']."` WHERE `id_struct` = ".$_last_id);
	if (!isset($__SR[0])) {
		DB("INSERT INTO `".$Config['table_relations']."`
			(`id_struct`, `id_module`, `id_page`) 
			VALUES
			('".$_last_id."', '0', '".$_last_id_page."')");
	}
	else {
		DB("UPDATE `".$Config['table_relations']."` SET
			`id_page` = '".$_last_id_page."'
			WHERE `id_struct` = ".$_last_id);
	}
    
	$__STRUCT = getStruct($_last_id);
    
    //exit();
?>