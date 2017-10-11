<?php
    include get('model_delete');
    $_RIGHT['title'] = 'Управление структурой сайта. Добавить страницу';
    $_SESSION['message'] = 'Страница "'.$__R[0]['menu_title'].'" удалена. <a class="link" href="'.$URL.'&action=restore&id='.$__R[0]['id'].'">Восстановить?</a>';
    setCookie('msg','1');
	header("Location: ".$URL."&action=blank");
?>