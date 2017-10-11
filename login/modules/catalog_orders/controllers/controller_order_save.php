<?php
include get('model_order_save');
$_SESSION['message'] = 'Изменения сохранены';
setCookie('msg','1');
header("Location: ".$URL."&action=order_edit&id=".$G['id']);
?>
