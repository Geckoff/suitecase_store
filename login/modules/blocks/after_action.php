<?php
    include get('model_get_blocks_list');
    ob_start();
    include get('view_left');
    $_left_content = ob_get_contents();
    ob_end_clean();
    
    ob_start();
    include get('view_right');
    $_right_content = ob_get_contents();
    ob_end_clean();
    unset ($_tabs);
    
    $_LEFT['title'] = 'Список блоков';
    $_LEFT['content'] = isset($_left_content) ? $_left_content : '';
    $_RIGHT['content'] = isset($_right_content) ? $_right_content : '';
    unset($_left_content, $_right_content);
?>