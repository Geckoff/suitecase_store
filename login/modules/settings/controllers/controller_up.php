<?php
    DB_sort('up',$G['id'],$Config['settings_element'],'AND `id_setting` = (SELECT `id_setting` FROM '.$Config['settings_element'].' WHERE `id` = '.$G['id'].')');
	$_SESSION['message'] = 'Запись перемещена на уровень вверх';
	setCookie('msg','1');
    header('Location: '.$URL.'&action=blank');
?>