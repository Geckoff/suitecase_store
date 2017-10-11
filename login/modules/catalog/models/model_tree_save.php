<?php
	if(isset($P['description']['title']) && !empty($P['description']['title'])){
		$tmpOld = DB("select `title`, `fname`, `url` from `".$Config['table']['tree']."` where `id` = ".$G['id']);
		if($P['description']['fname'] != ''){
			if($P['description']['fname'] !== $tmpOld[0]['fname'] && !empty($tmpOld[0]['fname'])){
				 unlinkImage($tmpOld[0]['fname']);
				 saveImage($P['description']['fname']);
			}
			else if($tmpOld[0]['fname'] == ''){
				saveImage($P['description']['fname']);
			}
			else $P['description']['fname'] = $tmpOld[0]['fname'];
		}
		else{
			 unlinkImage($tmpOld[0]['fname']);
		}
		$url = '';
		if($P['description']['title'] != $tmpOld[0]['title']){
			$url = translit($P['description']['title']);
			$cntUrl = count(DB("select `url` from `".$Config['table']['tree']."` where `url` like '".$url."%'"));
			if($cntUrl>0){
				$url .= '-'.$cntUrl;
			}
			$url = ", `url` = '".$url."' ";
		}
		DB("update `".$Config['table']['tree']."`
			set `title` = '".$P['description']['title']."',
				`description` = '".$P['description']['description']."',
				`fname` = '".$P['description']['fname']."',
				`seo_title` = '".$P['seo']['title']."',
				`seo_keywords` = '".$P['seo']['keywords']."',
				`seo_description` = '".$P['seo']['description']."',
				`changed` = '".time()."'
				".$url." 
			where `id` = ".$G['id']);
		$_SESSION['message'] = 'Изменения сохранены';
		setCookie('msg','1');
	} else {
		$_SESSION['error'] = 'Название не может быть пустым';
		setCookie('msg','1');
	}
?>
