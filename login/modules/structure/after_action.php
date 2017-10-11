<?php
	ob_start();
	include $Config['MODEL_ROOT'].'/model_struct_tree.php';
	include $Config['VIEW_ROOT'].'/view_left.php';
	$_LEFT['content'] = ob_get_contents();
	ob_end_clean();

	ob_start();
	include $Config['VIEW_ROOT'].'/view_right.php';
	$_RIGHT['content'] = ob_get_contents();
	ob_end_clean();

	$_LEFT['title'] = 'Структура сайта';
?>