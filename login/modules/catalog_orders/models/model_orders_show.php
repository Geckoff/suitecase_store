<?php
$_PAGE = (isset($G['page']) && intval($G['page'] > 0)) ? (int)$G['page'] : 1;
$_TOTAL_PAGE = 0;
$_COUNT_PER_PAGE = (isset($_COOKIE['count']) && (int)$_COOKIE['count']>0) ? $_COOKIE['count'] : (int)$Config['count_per_page'];
$_ORDERS_COUNT = 0;
$ORDERS = array();
$ORDERS = DB("select * from `".$Config['catalog_orders']."` ".$_SHOW." order by `id` desc limit  ".$_COUNT_PER_PAGE * ($_PAGE - 1).",".$_COUNT_PER_PAGE);
for($i = 0, $cnt = count($ORDERS); $i < $cnt; $i++){
	$ORDERS[$i]['price']=number_format($ORDERS[$i]['price'],0,"."," ");
	$ORDERS[$i]['date'] = date('d-m-Y H:i',$ORDERS[$i]['date']);
}
$_ORDERS_COUNT = count(DB("SELECT `id` from `".$Config['catalog_orders']."` ".$_SHOW));
$_TOTAL_PAGE = ($_ORDERS_COUNT % $_COUNT_PER_PAGE == 0) ? $_ORDERS_COUNT / $_COUNT_PER_PAGE : ((int)($_ORDERS_COUNT / $_COUNT_PER_PAGE) + 1);
?>
