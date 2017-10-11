<?php
	if($G['parent']==0){
		DB("UPDATE ".$Config['settings']." SET `delete`=1 WHERE `id` = ".$G['id']);
		DB("UPDATE ".$Config['settings_element']." SET `delete`=1 WHERE `id_setting` = ".$G['id']."");
	}
	else{
		DB("UPDATE ".$Config['settings_element']." SET `delete`=1 WHERE `id_setting` = ".$G['parent']." AND `id` = ".$G['id']);
	}
	$_SESSION['message'] = 'Запись успешно удалена';
	setCookie('msg','1');
	header("Location: ".$URL."&action=blank");
?>