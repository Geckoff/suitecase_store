<?php
	DB_sort('down', $G['id'], $Config['table']['tree'], 'and `id_tree` = (select `id_tree` from `'.$Config['table']['tree'].'` where `id` = '.$G['id'].')');
?>
