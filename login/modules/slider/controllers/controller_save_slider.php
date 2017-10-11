<?php
    include get('model_save_slider');
    ob_start();
    $G['id'] = $_last_id; // Cодержит ID вставленной/отредактированной строки или 0
    include get('model_get_baner');
    include get('view_right_content_slider');
    $_SESSION['message'] = 'Слайдер успешно сохранен';
    setCookie('msg','1');
    $_right_content = ob_get_contents();
    ob_end_clean();
    header("Location: ".$URL."&action=blank");
?>