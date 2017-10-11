<?php
if(isset($P['description']['title']) && !empty($P['description']['title'])){
	$url = translit($P['description']['title']);
	$cntUrl = count(DB("select `url` from `".$Config['table']['item']."` where `url` like '".$url."%'"));
	if($cntUrl > 0){
		$url .= '-'.$cntUrl;
	}
	$sort = DB("select max(`sort`) as `max` from `".$Config['table']['item']."` where `id_tree` = ".$G['into']);
	$dstype = 0;
	$dsprice = 0;
	$fname = '';
	if(isset($P['description']['fname']) && !empty($P['description']['fname'])){
		if(rename($Config['dir']['tmp_dir'].'/'.$P['description']['fname'], $Config['dir']['data_dir'].'/'.$P['description']['fname'])){
			$fname = $P['description']['fname'];
		}
	}
	if((int)$P['description']['discount']['discount'] == 1){
		if($P['description']['discount']['type'] !== 'numeric'){
			$dstype = 1;
		}
		$dsprice = $P['description']['discount']['price'];
	}else{
		$dsprice = $P['description']['price'];
	}
	DB("insert into `".$Config['table']['item']."` 
					(`id_tree`,	`sort`,	`title`, `url`,	`description`, `fname`, `seo_title`,	`seo_keywords`, `seo_description`, `price`,
					`available`, `featured`, `special`, `discount`, `ds_type`, `ds_value`, `ds_user_value`, `ds_price`, `changed`, `active`)
            values (".$G['into'].",
                    '".((int)$sort[0]['max'] + 1)."',
                    '".$P['description']['title']."',
                    '".$url."',
                    '".$P['description']['description']."',
                    '".$fname."',
                    '".$P['seo']['title']."',
                    '".$P['seo']['keywords']."',
                    '".$P['seo']['description']."',
                    '".$P['description']['price']."',
                    '".$P['description']['available']."',
                    '".$P['description']['featured']."',
                    '".$P['description']['special']."',
                    '".(int)$P['description']['discount']['discount']."',
                    '".$dstype."',
                    '".$P['description']['discount']['value']."',
                    '".$P['description']['discount']['user_value']."',
                    '".$dsprice."',
                    '".time()."',
                    '".$P['description']['active']."')");
	$_last_id = (int)mysql_insert_id();
}
?>
