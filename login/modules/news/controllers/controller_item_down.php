<?php
	include get('model_item_down');
	header('Location: '.$_SERVER['HTTP_REFERER']);
	exit ();
?>