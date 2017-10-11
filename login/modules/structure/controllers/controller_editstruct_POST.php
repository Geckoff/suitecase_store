<?php
    include get('model_editstruct_POST');
    $_RIGHT['title'] = 'Управление структурой сайта. Редактирование';
	$_SESSION['message'] = 'Страница успешно сохранена';
    setCookie('msg','1');
	header("Location: ".$URL."&action=edit&id=".$P['id']);
?>