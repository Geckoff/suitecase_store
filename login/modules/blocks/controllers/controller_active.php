<?php
    include get('model_active');
	$_SESSION['message'] = 'Активность блока изменено';
    setCookie('msg','1');
	header("Location: ".$URL."&action=blocks_edit&id=".$G['id']);
?>