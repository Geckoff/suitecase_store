<?php
    /*-----------Вывод левой части--------------*/
    ob_start();
    include get('view_left');
    $_left_content = ob_get_contents();
    ob_end_clean();
    /*------------------------------------------*/

    $_LEFT['title'] = 'Настройки';
    $_RIGHT['title'] = 'Управление настройками';
    $_LEFT['content'] = isset($_left_content) ? $_left_content : '';
    $_RIGHT['content'] = isset($_right_content) ? $_right_content : '';
    unset($_left_content, $_right_content);
?>