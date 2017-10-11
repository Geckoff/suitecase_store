<?php
    include get('model_save');
    if ($error == 0){
		$_SESSION['message'] = 'Данные успешно добавлены';
	}
	else if ($error == 2){
		$_SESSION['message'] = 'Данные успешно обновлены';
	}
    else {
		$_SESSION['error'] = 'Пожалуйста, заполните корректно все поля';
    }
    setCookie('msg','1');
    if (!isset($ID)) {
        $ID = 0;
    }
	header("Location: ".$URL."&action=show&id=".$ID);
?>