<?php
	$P['name'] = translit($P['name']);
	
	DB("UPDATE `".$Config['main_table']."` SET
            `menu_title` = '".$P['menu_title']."', 
            `title` = '".$P['title']."', 
            `name` = '".$P['name']."', 
            `url` = '".$P['name_url']."',
            `text` = '".$P['text']."',
            `meta_title` = '".$P['meta_title']."', 
            `meta_keywords` = '".$P['meta_keywords']."', 
            `meta_description` = '".$P['meta_description']."'
        WHERE `id` = ".$P['id']);
	
	
	$__RELATION = getRelation($P['id']);
 
	if (isset($__RELATION[0]))
	{
		foreach($__RELATION as $__RKey => $__RVal)
		{
			DB("UPDATE `".$Config['table_relations']."` SET
				`id_module` = '".$P['module'][$__RVal['id']]."',
				`id_main_field` = '".$P['module_table'][$__RVal['id']]."'
				WHERE `id_struct` = '".$P['id']."' AND `id` = '".$__RVal['id']."'");
			if ($P['module'][$__RVal['id']] == 0 && $__RKey > 0)
				DB("DELETE FROM `".$Config['table_relations']."`
					WHERE `id_struct` = '".$P['id']."' AND `id` = '".$__RVal['id']."'");
		}
        
		$_module_name = '';
		$ConfigTemp = $Config;
		unset($Config);
		foreach ($_Menu as $_MenuVal) {
			if ($__RELATION[0]['id_module'] == $_MenuVal['id'])
				$_module_name = $_MenuVal['name'];
		}
		if ($_module_name != '') {
			include_once $ConfigTemp['MODULES_ROOT'].'/'.$_module_name.'/config.php';
			$__TABLE = DB("SELECT `id`, `".$Config['main_field']."` AS `main_field` FROM `".$Config['main_table']."` AS `main_table` WHERE `");
			unset($Config);
		}
		$Config = $ConfigTemp;
	} 
	if (isset($P['module'][-1]) && $P['module'][-1] > 0)
	{
		DB("INSERT INTO `".$Config['table_relations']."`
			(`id_struct`, `id_module`, `id_page`) 
			VALUES
			('".$P['id']."', '".$P['module'][-1]."', '0')");
	}
	
	$__STRUCT = getStruct($P['id']);
	$__RELATION = getRelation($P['id']);
	
	if (isset($__RELATION[0]))
	{
		getModuleRelation($__RELATION);
	}
	
	$_SESSION['message'] = 'Изменения успешно сохранены';
?>
