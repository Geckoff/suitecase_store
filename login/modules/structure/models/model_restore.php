<?php
	$__R = DB("SELECT * FROM ".$Config['main_table']." WHERE `id` = '".$G['id']."'");
	DB("UPDATE ".$Config['main_table']." SET `delete` = 0 WHERE `id` = '".$G['id']."'");
	$__STRUCT = getStruct($G['id']);
    $__RELATION = getRelation($G['id']);
	$_SESSION['message'] = 'Страница "'.$__R[0]['menu_title'].'" восстановлена';
?>