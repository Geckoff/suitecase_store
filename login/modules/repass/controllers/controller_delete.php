<?php
    include get('model_delete');
    $_SESSION['message'] = 'Пароль успешно удален';
    setCookie('msg','1');
    header("Location: ".$URL."&action=blank");
?>