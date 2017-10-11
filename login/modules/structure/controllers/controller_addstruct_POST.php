<?php
    include get('model_addstruct_POST');
    $_RIGHT['title'] = 'Управление структурой сайта. Добавление страницы';
	$_SESSION['message'] = 'Страница успешно добавлена';
    setCookie('msg','1');
	header("Location: ".$URL."&action=edit&id=".$_last_id);
?>