<?php
    include_once dirname(__FILE__)."/../models/delete_menu.php";
    
    ob_start();
    include $Config['MODEL_ROOT'].'/get_all_left_menus.php';
    include $Config['VIEW_ROOT'].'/left_content.php';
    $_left_content = ob_get_contents();
    ob_end_clean();
    
    ob_start();
    //include $Config['VIEW_ROOT'].'/right_content.php';
    $_right_content = ob_get_contents();
    ob_end_clean();
    
    $_RIGHT['title'] = 'Управление структурой меню';
    $_RIGHT['content'] = $_right_content;
    $_SESSION['message'] = 'Меню успешно удалено';
    setCookie('msg','1');
    $_LEFT['title'] = 'Список всех меню на сайте';
    $_LEFT['content'] = $_left_content;
    header('Location: '.$URL.'&action=blank');
?>