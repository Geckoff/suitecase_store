<?php
    $_Pages_list = DB("SELECT * FROM ".$Config['main_table']." WHERE `delete` = 0");
    ob_start();
    include get('view_left');
    $_left_content = ob_get_contents();
    ob_end_clean();
    
    ob_start();
    include get('view_right');
    $_right_content = ob_get_contents();
    ob_end_clean();
    unset ($_tabs);
    
    $_LEFT['title'] = 'Список пользователей';
    $_RIGHT['title'] = 'Управление паролями';
    $_LEFT['content'] = isset($_left_content) ? $_left_content : '';
    $_RIGHT['content'] = isset($_right_content) ? $_right_content : '';
    unset($_left_content, $_right_content);
?>