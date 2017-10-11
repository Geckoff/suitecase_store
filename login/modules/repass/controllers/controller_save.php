<?php
    if(empty($P['login']) || empty($P['oldpass']) || empty($P['newpass']) || empty($P['newpass2'])) {
        $_SESSION['info'] = 'Пожалуйста, заполните все поля!';
    }
    elseif($P['newpass'] != $P['newpass2']) {
    	$_SESSION['error'] = 'Вы неверно повторили новый пароль';
        setCookie('msg','1');
   	    header("Location: ".$URL."&action=blank");
    }
    else {
        include get('model_save');
        setCookie('msg','1');
   	    header("Location: ".$URL."&action=blank");
    }
?>