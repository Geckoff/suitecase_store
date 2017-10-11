<?php
	$__STRUCT = getStruct($G['id']);
	$_SESSION['message'] = 'Добавление страницы в раздел "'.$__STRUCT[0]['menu_title'].'"';
	$_substruct = $__STRUCT[0]['id'];
	unset($__STRUCT);
?>