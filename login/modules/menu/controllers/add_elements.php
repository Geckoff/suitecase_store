<?php
/*
    include_once dirname(__FILE__)."/../models/add_elements.php";
    ob_start();
    include $Config['MODEL_ROOT'].'/get_all_right_menus_elements.php';
    include $Config['MODEL_ROOT'].'/get_all_left_menus.php';
    include $Config['VIEW_ROOT'].'/left_content.php';
    $_left_content = ob_get_contents();
    ob_end_clean();
    ob_start();
    include $Config['VIEW_ROOT'].'/right_content.php';
    $_right_content = ob_get_contents();
    ob_end_clean();
    $_LEFT['title'] = 'Список всех меню на сайте';
    $_LEFT['content'] = $_left_content;
    $_RIGHT['title'] = 'Управление структурой меню';
    $_RIGHT['content'] = $_right_content;
    unset($_left_content, $_right_content);
*/
    include $Config['MODEL_ROOT']."/add_elements.php";
    setCookie('msg','1');
    $_SESSION['message'] = 'Меню успешно сохранено';  
    header('Location: '.$URL.'&action=show_elements&id='.$G['id']);
?>