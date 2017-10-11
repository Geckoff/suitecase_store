<?php
/*-----------Вывод левой части--------------*/
ob_start();
include get('view_left');
$_left_content = ob_get_contents();
ob_end_clean();
/*------------------------------------------*/

$_LEFT['title'] = 'Структура раздела';
$_LEFT['content'] = isset($_left_content) ? $_left_content : '';
$_RIGHT['title'] = isset($_right_title) ? $_right_title : '';
$_RIGHT['content'] = isset($_right_content) ? $_right_content : '';
?>
