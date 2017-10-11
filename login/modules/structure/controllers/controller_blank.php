<?php
    if (isset($G['id'])) {
    	include get('model_blank');
    }
    $_RIGHT['title'] = 'Управление структурой сайта. Добавление страницы';
    if ($action == 'substruct') {
        $_SESSION['info'] = 'Добавление подстраницы';    
    }
?>