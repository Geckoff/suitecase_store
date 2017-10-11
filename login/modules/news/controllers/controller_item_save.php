<?php
	if(isset($G['id']) && (int)$G['id'] > 0){
		include get('model_item_description_edit');
		if(isset($_last_id) && !empty($_last_id)){
			include get('model_item_images_save');
			$_SESSION['message'] = 'Изменения сохранены';
			setCookie('msg','1');
			$_this = getInfo($_last_id,$Config['table']['item'],'`id_tree`');
			header('Location: '.$URL.'&action=item_navigate&id_tree='.$_this['id_tree']);
		}else{
			$_SESSION['error'] = 'Название товара не может быть пустым';
			setCookie('msg','1');
			header('Location: '.$URL.'&action=item_edit&id='.$G['id']);	
		}
	}else if(isset($G['into']) && (int)$G['into'] > 0){
		include get('model_item_description_insert');
		if(isset($_last_id) && !empty($_last_id)){
			include get('model_item_images_save');
			$_SESSION['message'] = 'Изменения сохранены';
			setCookie('msg','1');
			header('Location: '.$URL.'&action=item_navigate&id_tree='.$G['into']);
		}else{
			$_SESSION['error'] = 'Название товара не может быть пустым';
			setCookie('msg','1');
			header('Location: '.$URL.'&action=item_append&into='.$G['into']);	
		}
	}else {
		$_SESSION['error'] = 'Что-то пошло не так...';
		setCookie('msg','1');
		header('Location: '.$URL.'&action=blank');
	}
	exit();
?>
