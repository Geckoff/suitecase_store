<?php
	$__R = getStruct($G['id']);
	DB("UPDATE ".$Config['main_table']." SET `delete` = 1 WHERE `id` = '".$G['id']."'");
?>