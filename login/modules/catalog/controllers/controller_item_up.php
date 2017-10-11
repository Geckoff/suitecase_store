<?php
	include get('model_item_up');
	header('Location: '.$_SERVER['HTTP_REFERER']);
	exit ();
?>