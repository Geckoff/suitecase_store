<?php
if(isset($P['description']['title']) && !empty($P['description']['title'])){
	$url = translit($P['description']['title']);
	$cntUrl = count(DB("select `url` from `".$Config['table']['item']."` where `url` like '".$url."%'"));
	if($cntUrl > 0){
		$url .= '-'.$cntUrl;
	}
	$sort = DB("select max(`sort`) as `max` from `".$Config['table']['item']."` where `id_tree` = ".$G['into']);
	$date = $fname = '';
	if(preg_match('/^([0-3]{1}\d{1})\.([0,1]{1}\d{1})\.(\d{4})\ ([0-2]{1}\d{1}):(\d{2})$/i', trim($P['description']['date']))){
		$tmp=explode(" ",$P['description']['date']);
		$d=explode(".",$tmp[0]);
		$t=explode(":",$tmp[1]);
		$date=mktime($t[0],$t[1],'0',$d[1],$d[0],$d[2]);	
	}else{
		$date = time();
	}
	if(isset($P['description']['fname']) && !empty($P['description']['fname'])){
		if(rename($Config['dir']['tmp_dir'].'/'.$P['description']['fname'], $Config['dir']['data_dir'].'/'.$P['description']['fname'])){
			$fname = $P['description']['fname'];
		}
	}
	DB("insert into `".$Config['table']['item']."` 
					(`id_tree`,	`sort`,	`title`, `url`, `date`, `announcement`, `description`, `fname`, `seo_title`, `seo_keywords`, `seo_description`, `check`, `changed`, `active`)
            values (".$G['into'].",
                    '".((int)$sort[0]['max'] + 1)."',
                    '".$P['description']['title']."',
                    '".$url."',
                    '".$date."',
                    '".$P['description']['announcement']."',
                    '".$P['description']['description']."',
                    '".$fname."',
                    '".$P['seo']['title']."',
                    '".$P['seo']['keywords']."',
                    '".$P['seo']['description']."',
                    '".$P['description']['check']."',
                    '".time()."',
                    '".$P['description']['active']."')");
	$_last_id = (int)mysql_insert_id();
}
?>
