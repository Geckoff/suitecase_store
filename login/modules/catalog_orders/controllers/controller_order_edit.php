<?php
include get('model_order_edit');
ob_start();
include get('view_order_edit');
$_RIGHT['content']=ob_get_contents();
$_RIGHT['title']='Информация о заказе';
ob_end_clean();
?>
