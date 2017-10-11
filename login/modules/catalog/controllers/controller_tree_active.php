<?php
	include get('model_tree_active');
	header('Location: '.$_SERVER['HTTP_REFERER']);
	exit ();
?>