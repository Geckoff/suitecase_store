<?php
	session_start();
	include_once dirname(__FILE__).'/../config/admin_start.php';
	include_once dirname(__FILE__).'/modules/catalog/config.php';
	include_once dirname(__FILE__).'/modules/catalog/before_action.php';
	
	saveVal($_GET, array('id', 'idtree','oldSort', 'newSort','url','action','id_tree'), array('INT', 'INT', 'INT', 'INT', 'STRING_ADDSL', 'STRING_ADDSL', 'STRING_ADDSL'), '_');
	$URL = $_url;
	$action = $_action;
	if($_newSort > $_oldSort){
		DB("UPDATE `".$Config['table']['item']."` SET `sort` = `sort` - 1 WHERE `id_tree` = ".$_idtree." AND `sort` > ".$_oldSort." AND `sort` <= ".$_newSort);
		DB("UPDATE `".$Config['table']['item']."` SET `sort` = ".$_newSort." WHERE `id` = ".$_id);
		include_once dirname(__FILE__).'/modules/catalog/models/model_item_navigate.php';
		echo $_buff;
	}else if($_newSort < $_oldSort){
		DB("UPDATE `".$Config['table']['item']."` SET `sort` = `sort` + 1 WHERE `id_tree` = ".$_idtree." AND `sort` < ".$_oldSort." AND `sort` >= ".$_newSort);
		DB("UPDATE `".$Config['table']['item']."` SET `sort` = ".$_newSort." WHERE `id` = ".$_id);
		include_once dirname(__FILE__).'/modules/catalog/models/model_item_navigate.php';
		echo $_buff;
	}else{
		exit();
	}
?>
