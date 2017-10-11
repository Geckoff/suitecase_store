<?php
	$__R = DB("SELECT * FROM ".$Config['main_table']." WHERE `id` = '".$G['id']."'");
	DB("UPDATE `".$Config['main_table']."` SET `active` = '".(($__R[0]['active'])? '0': '1')."' WHERE `id` = '".$G['id']."'");
	$__STRUCT = getStruct($G['id']);
?>