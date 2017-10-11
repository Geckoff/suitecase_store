<?php
ob_start();
$_SESSION['info'] = 'Добавление нового слайдера';
include get('view_right_content_slider');
$_right_content = ob_get_contents();
ob_end_clean();
?>
