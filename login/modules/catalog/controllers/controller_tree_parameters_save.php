<?php
	include get('model_tree_parameters_save');
	$_SESSION['message'] = 'Изменения сохранены';
	setCookie('msg','1');
	header('Location:'.$_SERVER['HTTP_REFERER']);
	exit();
?>
