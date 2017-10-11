<?php
if(isset($G['select']) && !empty($G['select'])){
	switch($G['select']){
		case 'new': 
			$_RIGHT['title'] = 'Новые заказы';
			$_SHOW = "where `state` = '2'";
			break;
		case 'unfinished':
			$_RIGHT['title'] = 'Необработанные заказы';
			$_SHOW = "where `state` = '0'";
			break;
		case 'executed':
			$_RIGHT['title'] = 'Выполненные заказы';
			$_SHOW = "where `state` = '1'";
			break;
		case 'cancelled':
			$_RIGHT['title'] = 'Отмененные заказы';
			$_SHOW = "where `state` = '-1'";
			break;
		default :
			$_RIGHT['title'] = 'Все заказы';
			$_SHOW = '';
			break;
	}
} else {
	$_RIGHT['title'] = 'Все заказы';
	$_SHOW = '';
}
include get('model_orders_show');
ob_start();
include get('view_orders_show');
$_RIGHT['content']=ob_get_contents();
ob_end_clean();
?>
