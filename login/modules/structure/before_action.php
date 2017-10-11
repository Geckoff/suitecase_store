<?php
    // структура по ID структуры
    function getStruct($id)
    {
    	global $Config;
    	return DB("SELECT * FROM `".$Config['main_table']."` WHERE `id` = '".$id."'");
    }
    
    // мета теги по ID структуры
    function getMeta($id)
    {
    	global $Config;
    	return DB("SELECT * FROM `".$Config['table_meta']."` WHERE id_struct = '".$id."' LIMIT 1");
    }
    
    // страница по ID структуры
    function getPage($id)
    {
    	global $Config;
    	return DB("SELECT * FROM `".$Config['table_pages']."`
    			   INNER JOIN `".$Config['table_relations']."` 
    					ON `".$Config['table_relations']."`.`id_page` = `".$Config['table_pages']."`.`id`
    			   WHERE `".$Config['table_relations']."`.`id_struct` = '".$id."' LIMIT 1");
    }
    
    // связь с модулями по ID структуры
    function getRelation($id)
    {
    	global $Config;
    	return DB("SELECT * FROM `".$Config['table_relations']."` WHERE `id_struct` = '".$id."'");
    }
    
    // получения списка записей главной таблицы связанного модуля
    function getModuleRelation(&$_RELATION)
    {
    	global $Config, $_Menu, $AdminConfig;
    	$ConfigTemp = $Config;
    	unset($Config);
    	$_count = count($_RELATION);
    	for($i = 0; $i < $_count; $i++)
    	{
    		$_module_name = '';
    		foreach ($_Menu as $_MenuVal)
    		{
    			if ($_RELATION[$i]['id_module'] == $_MenuVal['id'])
    				$_module_name = $_MenuVal['name'];
    		}
    		if (!empty($_module_name)) {
    			include($ConfigTemp['MODULES_ROOT'].'/'.$_module_name.'/config.php');
    			$_RELATION[$i]['module_table'] = DB("SELECT `id`, `".$Config['main_field']."` AS `main_field` FROM `".$Config['main_table']."` AS `main_table` WHERE `delete` = 0");
    			unset($Config);
    		}
    	}
    	$Config = $ConfigTemp;
    }
?>
