<?php
    include get('model_save');
    ob_start();
    $G['id'] = $_last_id; //содержит ID вставленной/отредактированной строки или 0
    include get('model_get_baner');
    include get('view_right_content_item');
	if($error==2){
		$_SESSION['error'] = 'Слайд нельзя добавить без картинки';
		setCookie('msg','1');
		$_right_content = ob_get_contents();
		ob_end_clean();
		header("Location: ".$URL."&action=add&parent=".$P['parent']);
	}
	else{
		$_SESSION['message'] = 'Слайд успешно сохранен';
		setCookie('msg','1');
		$_right_content = ob_get_contents();
		ob_end_clean();
		header("Location: ".$URL."&action=show&id=".$G['id']."&slider=0");
	}
?>
