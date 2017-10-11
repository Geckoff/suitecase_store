<?php
    ob_start();
    include get('model_settings');
    include get('view_right_content');
    $_SESSION['info'] = 'Для редактирования настроек воспользуйтесь меню слева';
    $_right_content = ob_get_contents();
    ob_end_clean();
?>