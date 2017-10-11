<?php
	if (isset($P['checkbox'])){
		switch ($P['action'])
		{
			case 'Показать' : set_active($P['checkbox']); break;
			case 'Скрыть' : set_not_active($P['checkbox']); break;
			case 'Удалить' : set_delete($P['checkbox']); break;
			case 'Показать не активные' : header('Location: '.$URL.'&action=n-active&id_tree='.$G['id_tree']);exit();
			case 'Показать все' : header('Location: '.$URL.'&action=item_navigate&id_tree='.$G['id_tree']);exit();
			default: break;
		}
	}
?>
