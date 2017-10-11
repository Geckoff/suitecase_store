<?php
$DO = array(
	'blank' => array(array(), array(), 'controller_item_navigate.php'),
	// common tree actions
	'tree_append' => array(array('into' => 'INT', 'title' => 'STRING'), array(), 'controller_tree_append.php'),
	'tree_up' => array(array('id' => 'INT'), array(), 'controller_tree_up.php'),
	'tree_down' => array(array('id' => 'INT'), array(), 'controller_tree_down.php'),
	'tree_active' => array(array('id' => 'INT'), array(), 'controller_tree_active.php'),
	'tree_delete' => array(array('id' => 'INT'), array(), 'controller_tree_delete.php'),
	'tree_edit' => array(array('id' => 'INT'), array(), 'controller_tree_edit.php'),
	'tree_save' => array(array('id' => 'INT'), array('description' => 'STRING', 'seo' => 'STRING'), 'controller_tree_save.php'),
	// common item actions
	'item_navigate' => array(array(), array(), 'controller_item_navigate.php'),
	'n-active' => array(array(), array(), 'controller_item_navigate.php'),
	'total_save' => array(array('id_tree'=>'INT'), array('action' => 'STRING_ADDSL', 'checkbox' => 'STRING_ADDSL'), 'controller_total_save.php'),
	'item_up' => array(array('id' => 'INT'), array(), 'controller_item_up.php'),
	'item_down' => array(array('id' => 'INT'), array(), 'controller_item_down.php'),
	'item_append' => array(array('into' => 'INT'), array(), 'controller_item_edit.php'),
	'item_append_save' => array(array('into' => 'INT'), array('description' => 'STRING', 'seo' => 'STRING','images' => 'STRING_ADDSL'), 'controller_item_save.php'),
	'item_edit' => array(array('id' => 'INT'), array(), 'controller_item_edit.php'),
	'item_edit_save' => array(array('id' => 'INT'), array('description' => 'STRING', 'seo' => 'STRING','images' => 'STRING_ADDSL'), 'controller_item_save.php'),
);
?>
