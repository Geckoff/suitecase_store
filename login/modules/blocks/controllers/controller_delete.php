<?php
    include get('model_delete');
    $_SESSION['message'] = 'Блок успешно удален';
    setCookie('msg','1');
    header("Location: ".$URL."&action=blank");
?>