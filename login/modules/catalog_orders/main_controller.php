<?php
if($action == 'blank'){
	$_GET['select'] = 'all';
	if(!isset($_GET['page']) || empty($_GET['page']) || !(int)$_GET['page']){
		$_GET['page'] = 1;
	}
} else if ($action == 'orders_show'){
	if(!isset($_GET['select']) || empty($_GET['select'])){
		$_GET['select'] = 'all';
	}
}
$DO = array(
	'blank' => array(array('page' => 'INT','select' => 'STRING_ADDSL'), array(), 'controller_orders_show.php'),
	'orders_show' => array(array('page' => 'INT','select' => 'STRING_ADDSL'), array(), 'controller_orders_show.php'),
	'all_items_save' => array(array('page'=>'INT'), array('action'=>'STRING_ADDSL','checkbox'=>'STRING_ADDSL'), 'controller_all_items_save.php'),
	'order_edit' => array(array('id' => 'INT'), array(), 'controller_order_edit.php'),
	'order_save' => array(array('id' => 'INT'), array('state' => 'INT'), 'controller_order_save.php'),
);
?>
