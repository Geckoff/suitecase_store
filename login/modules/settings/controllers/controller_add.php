<?php
    ob_start();
    $_SESSION['info'] = 'Добавление новой записи в настройки';
    include get('view_right_content_item');
    $_right_content = ob_get_contents();
    ob_end_clean();
?>