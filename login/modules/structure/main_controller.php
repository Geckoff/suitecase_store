<?php
$DO = array(
	// GET
	'blank' => array(array(), array(), 'controller_blank.php'),
	'substruct' => array(array('id'=>'INT'), array(), 'controller_blank.php'),
	'edit' => array(array('id'=>'INT'), array(), 'controller_edit.php'),
	'active' => array(array('id'=>'INT'), array(), 'controller_active.php'),
	'delete' => array(array('id'=>'INT'), array(), 'controller_delete.php'),
	'restore' => array(array('id'=>'INT'), array(), 'controller_restore.php'),
	'up' => array(array('id'=>'INT'), array(), 'controller_up.php'),
	'down' => array(array('id'=>'INT'), array(), 'controller_down.php'),
	
	// POST
	'addstructpost' => array(array(), array('substruct'=>'INT', 'menu_title'=>'STRING', 'title'=>'STRING', 'name'=>'STRING', 'meta_title'=>'STRING', 'meta_keywords'=>'STRING', 'meta_description'=>'STRING', 'module'=>'INT', 'text'=>'STRING'), 'controller_addstruct_POST.php'),
	'editstructpost' => array(array(), array('id'=>'INT', 'menu_title'=>'STRING', 'title'=>'STRING', 'name'=>'STRING', 'name_url'=>'STRING_ADDSL', 'meta_title'=>'STRING', 'meta_keywords'=>'STRING', 'meta_description'=>'STRING', 'module'=>'INT', 'module_table'=>'STRING', 'text'=>'STRING'), 'controller_editstruct_POST.php')
);
?>