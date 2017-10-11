<?php
	if(isset($G['into']) && (int)$G['into'] > 0){
		$_ID_TREE = $G['into'];
		$formaction = $URL.'&action=item_append_save&into='.$G['into'];
		$_this = getInfo($G['into'],$Config['table']['tree'],'`title`');
		$_right_title = 'Добавление товара в <strong>'.$_this['title'].'</strong>';
	} else if(isset($G['id']) && (int)$G['id'] > 0) {
		$_ID_TREE = 0;
		include get('model_item_load');
		$formaction = $URL."&action=item_edit_save&id=".$G['id'];
		$_this = getInfo($G['id'],$Config['table']['item'],'`title`');
		$_right_title = 'Информация о товаре <strong>'.$_this['title'].'</strong>';
	} else{
		$_SESSION['error'] = 'Что-то пошло не так...';
		setCookie('msg','1');
		header('Location :'.$URL.'&action=blank');
		exit();
	}
	
	ob_start();
	include get('view_item_description');
	$_tabs[0]['title'] = 'Свойства';
	$_tabs[0]['content'] = ob_get_contents();
	ob_end_clean();

	ob_start();
	include get('view_item_seo');
	$_tabs[1]['title'] = 'SEO-оптимизация';
	$_tabs[1]['content'] = ob_get_contents();
	ob_end_clean();

	ob_start();
	include get('view_item_files');
	$_tabs[2]['title'] = 'Файлы';
	$_tabs[2]['content'] = ob_get_contents();
	ob_end_clean();

	if($Config['section']['parameters']){
		ob_start();
		include get('model_item_parameters_load');
		include get('view_item_parameters');
		$_tabs[3]['title'] = 'Параметры';
		$_tabs[3]['content'] = ob_get_contents();
		ob_end_clean();
	}
	ob_start();
	include get('view_item');
	$_right_content = ob_get_contents();
	ob_end_clean();
?>
