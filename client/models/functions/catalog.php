<?php
/* --------------------------------------- CATALOG ---------------------------------------------------- */
	
	function getCatalogItem($id_item){
		global $TABLE;	
    	$output = DB("select * from `".$TABLE['catalog_item']."` where `id` = '".$id_item."' and `active` = '1' and `delete` = '0' limit 1");
        if(isset($output[0])){
			if(strlen($output[0]['description']) > 2000){
				$output[0]['short_description'] = TruncateWords(strip_tags($output[0]['description']), 2000).'...';
		 	    $output[0]['show_short'] = 1;
			}else if(strlen($output[0]['description']) > 0 && strlen($output[0]['description']) <= 2000){
				$output[0]['short_description'] = strip_tags($output[0]['description']);
				$output[0]['show_short'] = 0;
			}else {
				$output[0]['show_short'] = 0;
			}
			$img = DB("select `title`, `alt`, `fname` from `".$TABLE['catalog_img']."` where `id_item` = '".$id_item."' order by `primary` desc, `sort` asc");
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
			$output[0]['params'] = getParameters($output[0]['id'], $output[0]['id_tree']);
			return $output[0];
		}else{
			return false;
		}
	}
	
	
	function getCatalogTree($root, $url, $parent = 0, $start = false, $end = false, $orderby = '', $search = false){
		global $TABLE;
		$treeChild = getAllTree($TABLE['catalog_tree'], $parent);
		$where = $having = "";
		$where = "WHERE `".$TABLE['catalog_item']."`.`id_tree` IN (".$parent;
		if(isset($treeChild)){
			for($i = 0, $cntTree = count($treeChild); $i < $cntTree; $i++) {
				$where .= ", ".$treeChild[$i]['id'];
			}
		}
		$where .= ") AND `".$TABLE['catalog_item']."`.`active` = 1 AND `".$TABLE['catalog_item']."`.`delete` = 0";
		if($search){ // При поиске
			$search =trim($search);
			$search = preg_replace('| +|', '%', $search);
			$having = "HAVING `".$TABLE['catalog_item']."`.`title` LIKE '%".$search."%' or `".$TABLE['catalog_item']."`.`description` LIKE '%".$search."%'";
		}
		// Запрос на вывод элементов из БД
		if($start !== false && $end !== false){
			$limit = " LIMIT ".$start.", ".$end;
			$output = DB("SELECT `".$TABLE['catalog_item']."`.*
				FROM `".$TABLE['catalog_item']."` RIGHT JOIN `".$TABLE['catalog_tree']."`
				ON `".$TABLE['catalog_item']."`.`id_tree` = `".$TABLE['catalog_tree']."`.`id`
				".$where." ".$having." ".$orderby." ".$limit);
			for($i = 0, $cnt = count($output); $i < $cnt; ++$i){
				if(strlen($output[$i]['description']) > 450){
					$output[$i]['description'] = TruncateWords(strip_tags($output[$i]['description']), 450).'...';
				}
				$img = DB("SELECT `title`, `alt`, `fname` FROM `".$TABLE['catalog_img']."` WHERE `id_item` = '".$output[$i]['id']."' ORDER BY `primary` DESC, `sort` ASC LIMIT 0, 1");
    			if(!isset($img[0]['fname']) || empty($img[0]['fname'])){
    				$output[$i]['img'][0]['title'] = 'Нет изображения';
    				$output[$i]['img'][0]['alt'] = 'Нет изображения';
    				$output[$i]['img'][0]['fname'] = 'no-photo.jpg';
    			}else {
    				$output[$i]['img'][0]['title'] = $img[0]['title'];
    				$output[$i]['img'][0]['alt'] = $img[0]['alt'];
    				$output[$i]['img'][0]['fname'] = $img[0]['fname'];
    			}
				$category = getUrlTree($TABLE['catalog_tree'], $output[$i]['id_tree'], $root);
				$category[]['url'] = $url;
				$tmp_cat = '';
				for($cntCat = count($category), $j = $cntCat -1; $j >= 0; $j--){
					$tmp_cat .= $category[$j]['url'].'/';
				}
				$output[$i]['url'] = $tmp_cat.$output[$i]['url'];
			}
		}else { // Вернет количество элементов
			return count(DB("SELECT `".$TABLE['catalog_item']."`.`id`,`".$TABLE['catalog_item']."`.`title`,`".$TABLE['catalog_item']."`.`description` FROM `".$TABLE['catalog_item']."` ".$where." ".$having));
		}
		
		return $output;
	}
	function getCatalogRoot($root, $url, $parent = 0, $start = false, $end = false){
		global $TABLE;
		
		// Запрос на вывод разделов из БД
		if($start !== false && $end !== false){
			$limit = " limit ".$start.", ".$end;
			$output = DB("select `".$TABLE['catalog_tree']."`.* from `".$TABLE['catalog_tree']."`
				where `".$TABLE['catalog_tree']."`.`id_tree` = '".$parent."' and `".$TABLE['catalog_tree']."`.`active` = '1' and `".$TABLE['catalog_tree']."`.`delete` = '0'
				order by `".$TABLE['catalog_tree']."`.`sort` asc
				".$limit);
			for($i = 0, $cnt = count($output); $i < $cnt; $i++){
				if(strlen($output[$i]['description']) > 450){
					$output[$i]['description'] = TruncateWords(strip_tags($output[$i]['description']), 450).'...';
				}else{
					$output[$i]['description'] = strip_tags($output[$i]['description']);
				}
				if(!isset($output[$i]['fname']) || empty($output[$i]['fname'])){
    				$output[$i]['img'][0]['fname'] = 'no-photo.jpg';
    			}else {
    				$output[$i]['img'][0]['fname'] = $output[$i]['fname'];
    			}
    			unset($output[$i]['fname']);
				$category = getUrlTree($TABLE['catalog_tree'], $output[$i]['id_tree'], $root);
				$category[]['url'] = $url;
				$tmp_cat = '';
				for($cntCat = count($category), $j = $cntCat -1; $j >= 0; $j--){
					$tmp_cat .= $category[$j]['url'].'/';
				}
				$output[$i]['url'] = $tmp_cat.$output[$i]['url'];
			}
		}else{ // Вернет количество разделов
			return count(DB("select `".$TABLE['catalog_tree']."`.`id` from `".$TABLE['catalog_tree']."`
				where `".$TABLE['catalog_tree']."`.`id_tree` = '".$parent."' and `".$TABLE['catalog_tree']."`.`active` = '1' and `".$TABLE['catalog_tree']."`.`delete` = '0'"));
		}
		
		return $output;
	}
	
	// Получение параметров для товара
	function get_id($current_id, $count = 0) {
		global $TABLE;
		$_count = DB("select COUNT(id) AS `count` from ".$TABLE['catalog_parameters']." where id_tree = ".$current_id);
		if(isset($_count[0]) && (int)$_count[0]['count'] > 0) {
			return $current_id;
		}
		elseif(++$count < 100) {
			$_parent = DB("select id_tree from ".$TABLE['catalog_tree']." where id = ".$current_id);
			if(isset($_parent[0]) && (int)$_parent[0]['id_tree'] > 0)
				return get_id($_parent[0]['id_tree'],$count);
			else
				return 0;
		}
	}
	
    function getParameters($id, $_id_tree){
		global $TABLE;
		$PARAMETERS = array();
		$_id_tree = get_id($_id_tree);
		$i = 0;
		$_params_group = DB("select `id`,`title` from `".$TABLE['catalog_parameters']."` where `id_tree` = '".$_id_tree."' and `id_group` = '0' and `active` = '1' and `delete` = 0 order by `sort` asc");
		foreach($_params_group as $_params_group_val) {
			$PARAMETERS[$i]['name'] = $_params_group_val['title'];
			$PARAMETERS[$i]['parameters'] = array();
			$_params = DB("select `id`,`title`,`type` from `".$TABLE['catalog_parameters']."` where `id_tree` = '".$_id_tree."' and `id_group` = '".$_params_group_val['id']."' and `active` = '1' and `delete` = 0 order by `sort` asc");
			$j = 0;
			foreach($_params as $_params_val) {
				$_value='';
				if(isset($id)){
					$res=DB("select `value` from `".$TABLE['catalog_item_parameters']."` where `id_item` = '".$id."' and `id_parameter` = '".$_params_val['id']."' limit 1");
					if(isset($res[0]['value']) && $res[0]['value']!==''){
						$_value=$res[0]['value'];	
					}
					else $_value='';
				}
				else $_value='';
				$PARAMETERS[$i]['parameters'][$j]['id'] = $_params_val['id'];
				$PARAMETERS[$i]['parameters'][$j]['name'] = $_params_val['title'];
				$PARAMETERS[$i]['parameters'][$j]['type'] = (int)$_params_val['type'];
				if($_value === '' || !isset($_value)) {
					unset($PARAMETERS[$i]['parameters'][$j]);
				} else {
					if((int)$_params_val['type'] == 1 && $_value === '1'){$PARAMETERS[$i]['parameters'][$j]['value'] = '<span class="plus"></span>';}
					else if((int)$_params_val['type'] == 1 && $_value === '0'){$PARAMETERS[$i]['parameters'][$j]['value'] = '<span class="minus"></span>';}
					else $PARAMETERS[$i]['parameters'][$j]['value'] = $_value;
				}
				$j++;
			}
			$PARAMETERS[$i]['parameters'] = array_values($PARAMETERS[$i]['parameters']);
			if(!isset($PARAMETERS[$i]['parameters']) || empty($PARAMETERS[$i]['parameters'])){ unset($PARAMETERS[$i]);}
			$i++;
		}
		$PARAMETERS = array_values($PARAMETERS);
		unset($_params,$_params_group,$_params_val,$_params_group_val,$_id_tree,$_value);	
		return $PARAMETERS;
	}

?>
