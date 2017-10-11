<?php
if(isset($P['description']['title']) && !empty($P['description']['title'])){
	$tmpOld = DB("select `title`, `fname` from `".$Config['table']['item']."` where `id` = ".$G['id']);
	$date = $fname = '';
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
	if(preg_match('/^([0-3]{1}\d{1})\.([0,1]{1}\d{1})\.(\d{4})\ ([0-2]{1}\d{1}):(\d{2})$/i', trim($P['description']['date']))){
		$tmp=explode(" ",$P['description']['date']);
		$d=explode(".",$tmp[0]);
		$t=explode(":",$tmp[1]);
		$date=mktime($t[0],$t[1],'0',$d[1],$d[0],$d[2]);	
	}else{
		$date = time();
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
	DB("update `".$Config['table']['item']."` 
			set `title` = '".$P['description']['title']."',
				`date` = '".$date."',
				`announcement` = '".$P['description']['announcement']."',
				`description` = '".$P['description']['description']."',
				`fname` = '".$fname."',
				`seo_title` = '".$P['seo']['title']."',
                `seo_keywords` = '".$P['seo']['keywords']."',
                `seo_description` = '".$P['seo']['description']."',
                `check` = '".$P['description']['check']."',
				`changed` = '".time()."',
				`active` = '".$P['description']['active']."'
				".$url."
			where `id` = ".$G['id']);
	unset($tmpOld);
	$_last_id = $G['id'];
}
?>
