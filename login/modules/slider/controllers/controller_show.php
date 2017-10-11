<?php
ob_start();
include get('model_get_baner');

if((int)$G['slider'] == 0){
	$_SESSION['info'] = 'Редактирование слайда';
	include get('view_right_content_item');
	}
else{
	$_SESSION['info'] = 'Редактирование слайдера';
	include get('view_right_content_slider');
	}

$_right_content = ob_get_contents();
ob_end_clean();
?>
