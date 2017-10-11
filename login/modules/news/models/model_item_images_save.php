<?php
if(isset($_last_id) && !empty($_last_id)){ //old item
	$old = DB("select `id`,`primary`,`fname` from `".$Config['table']['item_images']."` where `id_item` = ".$_last_id);
	if(isset($P['images']['fname']) && !empty($P['images']['fname'])){
		$old_count = count($old);
        $new_count = count($P['images']['fname']);
        for($i = 0; $i < $new_count; $i++){
			$insflag = false;
			for($j = 0; $j < $old_count; $j++){
				if($P['images']['fname'][$i] == $old[$j]['fname']){
					$insflag = true;
					DB("update `".$Config['table']['item_images']."`
							set `sort` = '".$i."',
								`title` = '".$P['images']['title'][$i]."',
								`alt` = '".$P['images']['alt'][$i]."',
								`primary` = '".$P['images']['primary'][$i]."'
							where `id` = ".$old[$j]['id']);
					break;
				}	
			}
			if($insflag == false){
				DB("insert into `".$Config['table']['item_images']."` (`id_item`, `sort`, `title`, `alt`, `fname`, `primary`)
						values ('".$_last_id."',
								'".$i."',
								'".$P['images']['title'][$i]."',
								'".$P['images']['alt'][$i]."',
								'".$P['images']['fname'][$i]."',
								'".$P['images']['primary'][$i]."')");
				saveImage($P['images']['fname'][$i]);
			}
        }
		for($i = 0; $i < $old_count; $i++){
			$delflag = false;
			for($j = 0; $j < $new_count; $j++){
				if($old[$i]['fname'] == $P['images']['fname'][$j]){
					$delflag = true;
					break;
				}	
			}
			if($delflag == false){
				DB("delete from `".$Config['table']['item_images']."` where `id`=".$old[$i]['id']);
				unlinkImage($old[$i]['fname']);
			}
        }
	}
	else{ //delete old images
		for($i = 0, $cnt = count($old); $i < $cnt; $i++){
		   unlinkImage($old[$i]['fname']);
        }
        DB("delete from `".$Config['table']['item_images']."` where `id_item`=".$_last_id);
	}
	unset($old);
}
?>
