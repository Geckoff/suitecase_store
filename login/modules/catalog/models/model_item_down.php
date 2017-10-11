<?php
	DB_sort('down', $G['id'], $Config['table']['item'], 'and `id_tree` = (select `id_tree` from `'.$Config['table']['item'].'` where `id` = '.$G['id'].')');
?>
