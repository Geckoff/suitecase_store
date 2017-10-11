<?php
    $__TEMP = getStruct($G['id']);
    DB_sort('up', $G['id'], 'struct', 'AND `parent` = '.$__TEMP[0]['parent']);
    $_RIGHT['title'] = 'Управление структурой сайта. Добавить страницу';
    $_SESSION['info'] = 'Страница перемещена на уровень вверх';
?>