<?php
    DB_sort('down',$G['id'],$Config['settings_element'],'AND id_setting = (SELECT id_setting FROM '.$Config['settings_element'].' WHERE id = '.$G['id'].')');
	$_SESSION['message'] = 'Запись перемещена на уровень вниз';
	setCookie('msg','1');
    header('Location: '.$URL.'&action=blank');
?>