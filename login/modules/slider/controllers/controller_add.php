<?php
    ob_start();
    $_SESSION['info'] = 'Добавление нового элемента слайдера';
    include get('view_right_content_item');
    $_right_content = ob_get_contents();
    ob_end_clean();
?>