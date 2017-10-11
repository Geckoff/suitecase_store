<?php
if(isset($P['description']['title']) && !empty($P['description']['title'])){
	$tmpOld = DB("select `title`, `fname` from `".$Config['table']['item']."` where `id` = ".$G['id']);
	$fname = '';
	if(isset($P['description']['fname']) && !empty($P['description']['fname'])){
		if($P['description']['fname'] !== $tmpOld[0]['fname'] && !empty($tmpOld[0]['fname'])){
			unlink($Config['dir']['data_dir'].'/'.$tmpOld[0]['fname']);
			rename($Config['dir']['tmp_dir'].'/'.$P['description']['fname'],$Config['dir']['data_dir'].'/'.$P['description']['fname']);
			$fname = $P['description']['fname'];
		} else if($tmpOld[0]['fname'] == ''){
			rename($Config['dir']['tmp_dir'].'/'.$P['description']['fname'],$Config['dir']['data_dir'].'/'.$P['description']['fname']);
			$fname = $P['description']['fname'];
		} else $fname = $tmpOld[0]['fname'];
	} else {
		if(!empty($tmpOld[0]['fname'])){
			unlink($Config['dir']['data_dir'].'/'.$tmpOld[0]['fname']);
		}
		$fname = '';
	}
	$url = '';
	if($P['description']['title'] != $tmpOld[0]['title']){
		$url = translit($P['description']['title']);
		$cntUrl = count(DB("select `url` from `".$Config['table']['item']."` where `url` like '".$url."%'"));
		if($cntUrl > 0){
			$url .= '-'.$cntUrl;
		}
		$url = ", `url` = '".$url."' ";
	}
	$dstype = 0;
	$dsprice = 0;
	if((int)$P['description']['discount']['discount'] == 1){
		if($P['description']['discount']['type'] !== 'numeric'){
			$dstype = 1;
		}
		$dsprice = $P['description']['discount']['price'];
	}else{
		$dsprice = $P['description']['price'];
	}
	DB("update `".$Config['table']['item']."` 
			set `title` = '".$P['description']['title']."',
				`description` = '".$P['description']['description']."',
				`fname` = '".$fname."',
				`seo_title` = '".$P['seo']['title']."',
                `seo_keywords` = '".$P['seo']['keywords']."',
                `seo_description` = '".$P['seo']['description']."',
				`price` = '".$P['description']['price']."',
				`available` = '".$P['description']['available']."',
				`featured` = '".$P['description']['featured']."',
				`special` = '".$P['description']['special']."',
				`discount` = '".(int)$P['description']['discount']['discount']."',
				`ds_type` = '".$dstype."',
				`ds_value` = '".$P['description']['discount']['value']."',
				`ds_user_value` = '".$P['description']['discount']['user_value']."',
				`ds_price` = '".$dsprice."',
				`changed` = '".time()."',
				`active` = '".$P['description']['active']."'
				".$url."
			where `id` = ".$G['id']);
	unset($tmpOld);
	$_last_id = $G['id'];
}
?>
