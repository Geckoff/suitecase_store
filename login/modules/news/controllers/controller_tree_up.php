<?php
	include get('model_tree_up');
	header('Location: '.$_SERVER['HTTP_REFERER']);
	exit ();
?>