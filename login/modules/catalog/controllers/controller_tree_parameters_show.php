<?php
	ob_start();
	include get('model_tree_parameters_show');
	include get('view_tree_parameters');
	$_this = getInfo($G['id'],$Config['table']['tree'],'`title`');
	$_right_title= 'Редактирование параметров раздела <strong>'.$_this['title'].'</strong>';
	$_right_content = ob_get_contents();
	ob_end_clean();
?>
