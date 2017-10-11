<?php
	$ITEM = DB("select * from `".$Config['table']['item']."` where `id` = '".$G['id']."' limit 0, 1");
	$ITEM = $ITEM[0];
	$ITEM['images'] = DB("select * from `".$Config['table']['item_images']."` where `id_item` = '".$G['id']."' order by `sort` asc");
?>
