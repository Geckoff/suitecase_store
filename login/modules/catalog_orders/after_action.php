<?php
/*-----------Вывод левой части--------------*/
ob_start();
include get('view_left');
$_left_content = ob_get_contents();
ob_end_clean();
/*------------------------------------------*/

/*-----------Вывод правой части--------------*/
ob_start();
include get('view_right');
$_right_content = ob_get_contents();
ob_end_clean();
unset ($TITLE,$CONTENT);
/*------------------------------------------*/
$_LEFT['title'] = 'Заказы';
$_LEFT['content'] = isset($_left_content) ? $_left_content : '';
$_RIGHT['content'] = isset($_right_content) ? $_right_content : '';
unset($_left_content, $_right_content);
?>
