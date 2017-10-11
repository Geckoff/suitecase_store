<?php
	include get('model_tree_down');
	header('Location: '.$_SERVER['HTTP_REFERER']);
	exit ();
?>