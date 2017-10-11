<?php
	include get('model_tree_save');
	header('Location: '.$URL.'&action=tree_edit&id='.$G['id']);
	exit ();
?>
