<?php
    ob_start();
    include get('model_settings_elements');
    include get('view_right_content_item');
    $_SESSION['info'] = 'Редактирование записи';
    $_right_content = ob_get_contents();
    ob_end_clean();
?>