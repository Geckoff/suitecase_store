<?php
    include get('model_active');
    $_RIGHT['title'] = 'Управление структурой сайта. Добавить страницу';
	$_SESSION['message'] = 'Страница "'.$__R[0]['menu_title'].'" <b>'.((!$__R[0]['active'])? 'активна': 'не активна').'</b>';
    setCookie('msg','1');
	header("Location: ".$URL."&action=edit&id=".$G['id']);
?>