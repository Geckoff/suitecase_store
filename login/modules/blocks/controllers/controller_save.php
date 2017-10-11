<?php
    if($_POST['name'] == '') {
        $_BLOCKS[0]['name'] = $_POST['name'];
        $_BLOCKS[0]['content'] = $_POST['content'];
        $_SESSION['info'] = 'Название блока не было заполнено';
    }
    else {
        include get('model_save');
        $G['id'] = $_WORKER_ID;
        include get('model_edit');
    	$_SESSION['message'] = 'Сохранение прошло успешно';
        setCookie('msg','1');
    	header("Location: ".$URL."&action=blocks_edit&id=".$G['id']);
    }
    $_RIGHT['title'] = 'Редактирование блока';
?>