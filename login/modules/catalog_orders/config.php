<?php
$Config = array(
	'title' => 'Заказы', 
	'main_table' => 'catalog_orders',
	'main_field' => 'name',
	'data' => array(),
	
	'catalog_orders' => 'catalog_orders',
	'catalog_orders_products' => 'catalog_orders_products',
	'catalog_tree' => 'catalog_tree',
	'catalog_item' => 'catalog_item',
    'modules' => 'modules',
    'struct' => 'struct',
    'struct_relations' => 'struct_relations',
   	
   	'count_per_page' => 10,
   	
	//необязательные параметры модуля
	'MODULES_ROOT' => dirname(__FILE__).'/..',
	'MODULE_ROOT' => dirname(__FILE__),
	'CONTROLLER_ROOT' => dirname(__FILE__).'/controllers',
	'MODEL_ROOT' => dirname(__FILE__).'/models',
	'VIEW_ROOT' => dirname(__FILE__).'/views',
	'DATA_ROOT' => $AdminConfig['DATA_ROOT'].'/catalog_orders',
	

);
?>
