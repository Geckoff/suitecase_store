<?php
/* --------------------------------------- NEWS ---------------------------------------------------- */
    
    function getNewsItem($id_item){
		global $TABLE;
    	$output = DB("select * from `".$TABLE['news_item']."` where `id` = '".$id_item."' and `active` = '1' and `delete` = '0' limit 1");
        if(isset($output[0])){
			$img = DB("select `title`, `alt`, `fname` from `".$TABLE['news_img']."` where `id_item` = '".$id_item."' order by `primary` desc, `sort` asc");
			if(!isset($img[0])){
						$output[0]['img'][0]['title'] = 'Нет изображения';
						$output[0]['img'][0]['alt'] = 'Нет изображения';
						$output[0]['img'][0]['fname'] = 'no-photo.jpg';
			}else{
				for($j = 0, $cntIMG = count($img); $j < $cntIMG; $j++) {
					if(!isset($img[$j]['fname']) || empty($img[$j]['fname'])){
						$output[0]['img'][$j]['title'] = 'Нет изображения';
						$output[0]['img'][$j]['alt'] = 'Нет изображения';
						$output[0]['img'][$j]['fname'] = 'no-photo.jpg';
					}else{
						$output[0]['img'][$j]['title'] = $img[$j]['title'];
						$output[0]['img'][$j]['alt'] = $img[$j]['alt'];
						$output[0]['img'][$j]['fname'] = $img[$j]['fname'];
					}
				}
			}
			return $output[0];
		}else{
			return false;
		}
	}
	
    function getNewsTree($root, $url, $parent = 0, $start = false, $end = false, $orderby = '', $search = false){
		global $TABLE;
		$treeChild = getAllTree($TABLE['news_tree'], $parent);
		$where = $having = "";
		$where = "WHERE `".$TABLE['news_item']."`.`id_tree` IN (".$parent;
		if(isset($treeChild)){
			for($i = 0, $cntTree = count($treeChild); $i < $cntTree; $i++) {
				$where .= ", ".$treeChild[$i]['id'];
			}
		}
		$where .= ") AND `".$TABLE['news_item']."`.`active` = 1 AND `".$TABLE['news_item']."`.`delete` = 0";
		if($search){ // При поиске
			$search =trim($search);
			$search = preg_replace('| +|', '%', $search);
			$having = "HAVING `".$TABLE['news_item']."`.`title` LIKE '%".$search."%' or `".$TABLE['news_item']."`.`description` LIKE '%".$search."%'";
		}
		
		// Запрос на вывод элементов из БД
		if($start !== false && $end !== false){
			$limit = " LIMIT ".$start.", ".$end;
			$output = DB("select `".$TABLE['news_item']."`.*
				FROM `".$TABLE['news_item']."` RIGHT JOIN `".$TABLE['news_tree']."`
				ON `".$TABLE['news_item']."`.`id_tree` = `".$TABLE['news_tree']."`.`id`
				".$where." ".$having." ".$orderby." ".$limit);
			for($i = 0, $cnt = count($output); $i < $cnt; ++$i){
				$img = DB("SELECT `title`, `alt`, `fname` FROM `".$TABLE['news_img']."` WHERE `id_item` = '".$output[$i]['id']."' ORDER BY `primary` DESC, `sort` ASC LIMIT 0, 1");
    			if(!isset($img[0]['fname']) || empty($img[0]['fname'])){
    				$output[$i]['img'][0]['title'] = 'Нет изображения';
    				$output[$i]['img'][0]['alt'] = 'Нет изображения';
    				$output[$i]['img'][0]['fname'] = 'no-photo.jpg';
    			}else {
    				$output[$i]['img'][0]['title'] = $img[0]['title'];
    				$output[$i]['img'][0]['alt'] = $img[0]['alt'];
    				$output[$i]['img'][0]['fname'] = $img[0]['fname'];
    			}
				$category = getUrlTree($TABLE['news_tree'], $output[$i]['id_tree'], $root);
				$category[]['url'] = $url;
				$tmp_cat = '';
				for($cntCat = count($category), $j = $cntCat -1; $j >= 0; $j--){
					$tmp_cat .= $category[$j]['url'].'/';
				}
				$output[$i]['url'] = $tmp_cat.$output[$i]['url'];
			}
		}else { // Вернет количество элементов
			return count(DB("SELECT `".$TABLE['news_item']."`.`id`,`".$TABLE['news_item']."`.`title`,`".$TABLE['news_item']."`.`description` FROM `".$TABLE['news_item']."` ".$where." ".$having));
		}
		
		return $output;
	}
?>
