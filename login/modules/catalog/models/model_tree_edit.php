<?php
	$TREE = DB("select * from `".$Config['table']['tree']."` where `id`='".$G['id']."'");
	$TREE = $TREE[0];
	$_right_title = 'Редактирование раздела <strong>'.$TREE['title'].'</strong>';
?>
