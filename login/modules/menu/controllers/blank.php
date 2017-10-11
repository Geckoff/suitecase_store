<?php //базовый подконтроллер, обязателен во всех модулях
    ob_start();
    include $Config['MODEL_ROOT'].'/get_all_left_menus.php';
    include $Config['VIEW_ROOT'].'/left_content.php';
    $_left_content = ob_get_contents();
    ob_end_clean();
    
    $_LEFT['title'] = 'Меню';
    $_LEFT['content'] = $_left_content;
    
    $_SESSION['info'] = 'Для отображения структуры выберите меню или добавьте новое';
    $_RIGHT['title'] = 'Структура меню';
    $_RIGHT['content'] = '';
    
    unset($_left_content);
?>