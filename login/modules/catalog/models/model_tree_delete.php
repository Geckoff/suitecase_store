<?php
    $_where_tree = substr(get_tree($G['id'],'id'),0,-3);
    $_where_items = substr(get_tree($G['id'],'id_tree'),0,-3);
    
    if($Config['common']['move_to_trash']){
        DB("update `".$Config['table']['tree']."` set `delete` = '1', `changed` ='".time()."' where ".$_where_tree);
		DB("update `".$Config['table']['item']."` set `delete` = '1', `changed` ='".time()."' where  ".$_where_items);
    }
    else {
		$tmpItem = DB("select `id`,`fname` from `".$Config['table']['item']."` where ".$_where_items);
		foreach($tmpItem as $item){
			$tmpImg = DB("select `fname` from `".$Config['table']['item_images']."` where `id_item` = ".$item['id']);
			foreach($tmpImg as $file){
				unlinkImage($file['fname']);
			}
			if(!empty($item['fname'])){
				unlink($Config['dir']['data_dir'].$item['fname']);
			}
			DB("delete from `".$Config['table']['item_images']."` where `id_item` = ".$item['id']);
			DB("delete from `".$Config['table']['item_params']."` where `id_item` = ".$item['id']);
			DB("delete from `".$Config['table']['item']."` where `id` = ".$item['id']);
		}
		$tmpTree = DB("select `id`,`fname` from `".$Config['table']['tree']."` where ".$_where_tree);
		foreach($tmpTree as $tree){
			if(!empty($tree['fname'])){
				unlinkImage($tree['fname']);
			}
			DB("delete from `".$Config['table']['tree_params']."` where `id_tree` = ".$tree['id']);
			DB("delete from `".$Config['table']['tree']."` where `id` = ".$tree['id']);
		}
    }
?>
