<?php
/*
 * @author ООО "Фабрика проектов"
 * @copyright 2013
 *
 * function getLevelUrl($module_url, $item_table, $tree_table, $parent = 0)
 * function getTreeByID($id, $tree_table, $select = "*")
 * function buildNavMenu($module_url, $tree_table, $id_tree = 0, $parrent_url = '', $lvl = 0, &$href = false, &$_buf)
 * function getUrlTree($tree_table, $id_tree, $parent = 0, &$urlTree = false)
 * function getAllTree($tree_table, $id_tree, &$allTree = false)
 */

/* ----------------------------- TREE MODULES COMMON FUNCTION ----------------------------*/
    
	// Уровни вложенности     
	function getLevelUrl($module_url, $item_table, $tree_table, $parent = 0){
		$level['level'] = 'page';
		for($i=0, $cnt = count($module_url); $i < $cnt; $i++){
			$tmp = DB("select `id`,`id_tree` from `".$item_table."` where `url` = '".$module_url[$i]."' and `id_tree` = '".$parent."' and `active` = '1' and `delete` = '0' limit 0, 1"); // Проверка на элемент
			if(isset($tmp[0]['id']) && (int)($tmp[0]['id']) > 0){
				$level['level'] = 'item';
				$level['id'] = $tmp[0]['id'];
			}else{
				$tmp = DB("select `id`, `id_tree` from `".$tree_table."` where `url` = '".$module_url[$i]."' and `id_tree` = '".$parent."' and `active` = '1' and `delete` = '0' limit 0, 1"); // Проверка на дерево
				if(isset($tmp[0]['id']) && (int)($tmp[0]['id']) > 0){
					$level['level'] = 'tree';
					$level['id'] = $tmp[0]['id'];
					$parent = $tmp[0]['id'];
				}else{
					$level['level'] = '404';
					break;
				}
			}
		}
		return  $level;
	}
	
	// Получаем запись из таблицы "tree" по ID
    function getTreeByID($id, $tree_table, $select = "*") {
		return  DB("select ".$select." from `".$tree_table."` where `id` = '".$id."' and `active` = '1' and `delete` = '0' limit 1");
    }
    
	// Формирование меню категорий
	function buildNavMenu($module_url, $tree_table, $id_tree = 0,  $parrent_url = '', $lvl = 0, &$href = false, &$_buf = ''){
		if ($parrent_url == "mob_menu") {
			$parrent_url = "";	
			$mob_menu = true;
		}
		else {
			$mob_menu = false;	
		}
		global $MODULE_URL;
		if($href === false){
			$_buf = '';
			$href = array();
			$href[0] = $module_url;
		}
		$res = DB("select `id`, `title`, `id_tree`, `url` from `".$tree_table."` where `id_tree` = '".$id_tree."' and `active` = '1' and `delete` = '0' order by `sort` asc");
		if(isset($res[0]) && !empty($res[0])){
			$menu_level = (!$mob_menu) ? $lvl : "";
			$_buf .= '<ul class="menu_lvl_'.$menu_level.'">';
			if($parrent_url !== ''){
				$href[$lvl] = $parrent_url;
			}
			$lvl++;
			foreach($res as $key => $value){
				$_cl = '';
				if(isset($MODULE_URL)){
					for($i = 0, $cnt = count($MODULE_URL); $i < $cnt; $i++){
						if($MODULE_URL[$i] == $value['url']){
							$_cl = 'active';
							break;
						}
					}
				}
				if($value == end($res))	$_cl .= ' last'; else $_cl .= '';
				$link = '';
				for($i = 0; $i < $lvl; $i++){
					$link .= $href[$i].'/';
				}
				$menu_class = (!$mob_menu) ? $_cl : "";
				if ($mob_menu && $value['url'] == 'ryukzaki-polar-1') {
					$a_href = '#mm-2';
				}
				else {
					$a_href = $link.$value['url'];	
				}
				$_buf .= '<li class="'.$menu_class.'"><a href="'.$a_href.'">'.$value['title'].'</a>';
				buildNavMenu($module_url, $tree_table, $value['id'], $value['url'], $lvl, $href, $_buf);
				$_buf .= '</li>';
			}
			$_buf .= '</ul>';
		}
		return $_buf;
	}
	
	// Рекурсия таблицы "tree" для получения полного URL категории (parent <- id_tree)
	function getUrlTree($tree_table, $id_tree, $parent = 0, &$urlTree = false){
        if ($urlTree === false){
            $urlTree = array();        
        }
        $res = DB("select `id`, `id_tree`, `title`, `url` from `".$tree_table."` where `id` = '".$id_tree."' and `active` = '1' and `delete` = '0' limit 1");
        if(isset($res[0]) && !empty($res[0])){
			if($res[0]['id'] == $parent){
			}else{
				$urlTree[] = $res[0];
				getUrlTree($tree_table, $res[0]['id_tree'], $parent, $urlTree);
			}
		}
		return $urlTree;
	}
   	// Рекурсия таблицы "tree" для получения всех дочерних категорий (id_tree -> ..)
    
	function getAllTree($tree_table, $id_tree, &$allTree = false){
        if ($allTree === false){
            $allTree = array();        
        }
		$res = DB("select `id`, `id_tree`, `title`, `url` from `".$tree_table."` where `id_tree` = '".$id_tree."' and `active` = '1' and `delete` = '0' order by `id_tree` asc, `sort` asc");
		if(isset($res[0]) && !empty($res[0])){
			foreach($res as $key => $value){
				$allTree[] = $value;
				getAllTree($tree_table, $value['id'], $allTree);
			}
		}
		return $allTree;
	}

/* --------------------------------------- STRUCT ---------------------------------------------------- */
    function getRelation($id){
    	global $TABLE;
    	$r =  DB("SELECT `id_main_field` FROM `".$TABLE['struct_relations']."` WHERE `id_struct` = '".$id."'");
    	if(isset($r[0]['id_main_field']) && (int)$r[0]['id_main_field'] > 0){
			return $r[0]['id_main_field'];
		}else{
			return 0;
		}
    }
    // Получить текущую страницу + связь с модулем
    function getCurrentPage($array){
        global $TABLE;
        for($i = 0, $cnt = count($array); $i < $cnt; ++$i) {
            $S = getStructByName($array[$i], '`id`, `parent`, `name`');
            if(isset($S[0])){
				if($i == 0){
					$M = DB("SELECT `".$TABLE['struct_relations']."`.`id_module`, `".$TABLE['struct_relations']."`.`id_main_field`, `".$TABLE['modules']."`.`name` 
								FROM `".$TABLE['struct_relations']."` INNER JOIN `".$TABLE['modules']."` ON `".$TABLE['struct_relations']."`.`id_module` = `".$TABLE['modules']."`.`id`
								WHERE `".$TABLE['struct_relations']."`.`id_struct` = ".$S[0]['id']." AND `".$TABLE['struct_relations']."`.`id_module` > 0 LIMIT 1");
					if(!isset($M[0])){
						$M[0] = array();
					}else {
						$S[0]['index'] = $i;
						break;
					}
				}else{
					$tS = getStructByName($array[$i-1], '`id`');
					if($S[0]['parent'] == $tS[0]['id']){
						$M = DB("SELECT `".$TABLE['struct_relations']."`.`id_module`, `".$TABLE['struct_relations']."`.`id_main_field`, `".$TABLE['modules']."`.`name` 
									FROM `".$TABLE['struct_relations']."` INNER JOIN `".$TABLE['modules']."` ON `".$TABLE['struct_relations']."`.`id_module` = `".$TABLE['modules']."`.`id`
									WHERE `".$TABLE['struct_relations']."`.`id_struct` = ".$S[0]['id']." AND `".$TABLE['struct_relations']."`.`id_module` > 0 LIMIT 1");
						if(!isset($M[0])){
							$M[0] = array();
						}else {
							$S[0]['index'] = $i;
							break;
						}
					}else{
						$error404 = true;
						$M[0] = array();
						$S[0] = array();
						break;
					}
				}
            }else{
				$error404 = true;
				$M[0] = array();
                $S[0] = array();
				break;
            }    
        } 
        return array('page' => $S[0], 'module' => $M[0]);   
    }
    // Получаем все записи из таблицы "struct"
    function getStruct($select = "*") {
        global $TABLE;
        return DB("select ".$select." from `".$TABLE['struct']."` where `active` = 1 and `delete` = 0 order by `sort`");
    }
    // Получаем запись из таблицы "struct" по ID
    function getStructByID($id, $select = "*") {
        global $TABLE;
        return DB("select ".$select." from `".$TABLE['struct']."` where `id` = '".$id."' and `active` = 1 and `delete` = 0 limit 1");
    }    
    // Получаем запись из таблицы "struct" по NAME
    function getStructByName($name, $select = "*") {
        global $TABLE;
        return DB("select ".$select." from `".$TABLE['struct']."` where `name` = '".$name."' and `active` = 1 and `delete` = 0 limit 1");
    } 
    // Получаем все записи из таблицы "struct" по ID родителя
    function getListStructByParent($parent, $select = "*") {
        global $TABLE;
        return DB("select ".$select." from `".$TABLE['struct']."` where `parent` = '".$parent."' and `active` = '1' and `delete` = 0 order by `sort` asc");
    }     
	// Строим меню по структуре
	function buildStructMenu($parent = 0, $lvl = 0, &$_buff = ''){
        global $PAGE, $TABLE, $ClientConfig;
		$res = '';
		$res = DB("SELECT `id`,`parent`,`menu_title`,`name`,`url` FROM `".$TABLE['struct']."` WHERE `parent` = ".(int)$parent." AND `active` = 1 AND `delete` = 0 ORDER BY `sort` ASC");
		if(isset($res[0]) && !empty($res[0])){
			$_buff .= '<ul class="menu_lvl_'.$lvl.'">';
			$lvl++;
			foreach($res as $_v){
				$_class = $_link = '';
				if(isset($PAGE['page']['id']) && $PAGE['page']['id'] == $_v['id']) $_class = 'class="active"'; else $_class = '';
				if(!empty($_v['url'])){
					$_v['link'] = $_v['url'];
				}else {
					$_v['link'] = $ClientConfig['HOST'].'/'.$_v['name'];
				}
				$_buff .= '<li><a '.$_class.' href="'.$_v['link'].'">'.$_v['menu_title'].'</a>';
				buildStructMenu($_v['id'], $lvl, $_buff);
				$_buff .= '</li>';
			}
			$_buff .= '</ul>';
		}
		return $_buff;
	}

/* --------------------------------------- MENU ---------------------------------------------------- */
    
    // Получаем все записи из таблицы "menu"
    function getMenu($select = "*") {
        global $TABLE;
        return DB("select ".$select." from `".$TABLE['menu']."` where `delete` = 0");
    }
    // Получаем запись из таблицы "menu" по ID
    function getMenuByID($id, $select = "*") {
        global $TABLE;
        return DB("select ".$select." from `".$TABLE['menu']."` where `id` = '".$id."' and `delete` = 0 limit 1");
    }    
    // Получаем все записи из таблицы "menu_item" по ID родителя
    function getListMenuByParent($id_parent, $select = "*") {
        global $TABLE;
        return DB("select ".$select." from `".$TABLE['menu_item']."` where `id_menu` = '".$id_parent."' and `delete` = 0");
    }  
    // Строим меню для сайта
    function buildMenu($id_parent) {
        global $ClientConfig, $TABLE;
		$R = DB("select `id`, `id_page`, `title`, `chpu`,`url` from `".$TABLE['menu_item']."` where `id_menu` = '".$id_parent."' and `delete` = 0");
		if(isset($R) && !empty($R)){
			for($i=0, $cnt = count($R); $i < $cnt; ++$i){
				if(isset($R[$i]['url']) && !empty($R[$i]['url'])){
					$R[$i]['link'] = $R[$i]['url'];
					unset($R[$i]['url']);
				}
				else{
					$link = getStructByID($R[$i]['id_page'], '`name`');
                    if (!empty($link[0]['name'])) {
                        $R[$i]['link'] = $ClientConfig['HOST'].'/'.$link[0]['name'];    
                    }
                    else {
                        $R[$i]['link'] = $ClientConfig['HOST'];   
                    }
					unset($R[$i]['url'], $link);
				}
			}
			$menu = $R;
        }
		else {
            $menu = array();
        }
		return $menu;
    }
    
/* --------------------------------------- BLOCKS ---------------------------------------------------- */
    
    // Получаем все записи из таблицы "blocks"
    function getBlocks($select = "*") {
        global $TABLE;
        return DB("select ".$select." from `".$TABLE['blocks']."` where `active` = 1 and `delete` = 0");
    }
    // Получаем запись из таблицы "blocks" по ID
    function getBlockByID($id, $select = "*") {
        global $TABLE;
        return DB("select ".$select." from `".$TABLE['blocks']."` where `id` = '".$id."' and `active` = 1 and `delete` = 0 limit 1");
    }
    
    
/* --------------------------------------- SLIDER ---------------------------------------------------- */
    
    // Получаем все записи из таблицы "slider" без детей
    function getSliders($select = "*") {
        global $TABLE;
        return DB("select ".$select." from `".$TABLE['slider']."` where `parent` = '0' and `active` = 1 and `delete` = 0 order by `sort`");
    }
    // Получаем запись из таблицы "slider" по ID
    function getSliderByID($id, $select = "*") {
        global $TABLE;
        return DB("select ".$select." from `".$TABLE['slider']."` where `id` = '".$id."' and `active` = 1 and `delete` = 0 limit 1");
    }    
    // Получаем все записи из таблицы "slider" по ID родителя
    function getListSlidesByParent($id_parent, $select = "*") {
        global $TABLE;
        return DB("select ".$select." from `".$TABLE['slider']."` where `parent` = '".$id_parent."' and `active` = 1 and `delete` = 0 order by `sort`");
    }
    
    
/* --------------------------------------- SETTINGS ---------------------------------------------------- */
    
    // Получаем все записи из таблицы "settings"
    function getSettings($select = "*") {
        global $TABLE;
        return DB("select ".$select." from `".$TABLE['settings']."` where `delete` = 0");
    }
    // Получаем запись из таблицы "settings" по ID
    function getSettingByID($id, $select = "*") {
        global $TABLE;
        return DB("select ".$select." from `".$TABLE['settings']."` where `id` = '".$id."' and `delete` = 0 limit 1");
    }    
    // Получаем все записи из таблицы "settings_element" по ID родителя
    function getListSettingsByParent($id_parent, $select = "*") {
        global $TABLE;
        return DB("select ".$select." from `".$TABLE['settings_element']."` where `id_setting` = '".$id_parent."' and `delete` = 0 order by `sort`");
    }    
    
      
/* --------------------------------------- REVIEWS ---------------------------------------------------- */
    
    // Получаем все записи из таблицы "reviews"
    function getReviews($select = "*") {
        global $TABLE;
        return DB("select ".$select." from `".$TABLE['reviews']."` where `active` = 1 and `delete` = 0");
    }
    // Получаем запись из таблицы "reviews" по ID
    function getReviewByID($id, $select = "*") {
        global $TABLE;
        return DB("select ".$select." from `".$TABLE['reviews']."` where `id` = '".$id."' and `active` = 1 and `delete` = 0 limit 1");
    }
	
/* --------------------------------------- OTHER FUNCTIONS ---------------------------------------------------- */

    // Удаление конечного слэша  
    function deleteEndSlash() {
        $uri = preg_replace("/\?.*/i",'', $_SERVER['REQUEST_URI']);
        if (strlen($uri)>1) {
            if (rtrim($uri,'/')!=$uri) {
                header("HTTP/1.1 301 Moved Permanently");
                header('Location: http://'.$_SERVER['SERVER_NAME'].str_replace($uri, rtrim($uri,'/'), $_SERVER['REQUEST_URI']));
                exit();    
            }
        }
    }
    function getInfo($fieldset = '*', $condition = '`id` = "0"', $table = '`struct`'){ // Need update!!!
		$res = DB("select ".$fieldset." from `".$table."` where ".$condition);
		return $res[0];
	}
	// Обрезать строку UTF-8 до нужного количества символов, не обрезав последнее слово
	function TruncateWords($text, $limit = 1000){
    	$text=mb_substr($text,0,$limit);
    	// если не пустая обрезаем до  последнего  пробела
    	if(mb_substr($text,mb_strlen($text)-1,1) && mb_strlen($text)==$limit)
    	{
    		$textret=mb_substr($text,0,mb_strlen($text)-mb_strlen(strrchr($text,' ')));
    		if(!empty($textret))
    		{
    			return $textret;
    		}
    	}
    	return $text;
    }
	// Pager
	function Pager($href, $curPage, $limitPage, $query = ''){

		$prevPage = $curPage - 1;
		$nextPage = $curPage + 1;
		
		if($limitPage > 11){
			if($curPage > 5){
				$startPage = $curPage - 5;
				$endPage = $curPage + 5;
			}else{
				$startPage = 1;
				$endPage = 11;
			}
			if($endPage > $limitPage){
				$startPage -= $endPage - $limitPage;
				$endPage = $limitPage;
			}
		}else{
			$startPage = 1;
			$endPage = $limitPage;
		}	

		$_pagerBuf = '<ul id="pager">';
		if($curPage == 1) {
			$_pagerBuf .= '<li class="disabled"><span>« Назад</span></li>';
		}else{
			$_pagerBuf .= '<li><a href="'.$href.'/page/'.$prevPage.$query.'">« Назад</a></li>';
		}
		if($startPage > 1) {
			$_pagerBuf .= '<li><a href="'.$href.'/page/1'.$query.'">1</a>&nbsp;...&nbsp;</li>';
			$startPage ++;
		}
		for($i = $startPage; $i < $endPage ; $i++){
			if($curPage == $i) {
			   $_pagerBuf .= '<li class="current"><span>'.$i.'</span></li>';
			}else{
			   $_pagerBuf .= '<li><a href="'.$href.'/page/'.$i.$query.'">'.$i.'</a></li>';
			}
		}
		if($curPage == $limitPage){
			$_pagerBuf .= '<li class="current"><span>'.$limitPage.'</span></li><li class="disabled"><span>Вперед »</span></li>';
		}else{
			if($endPage == $limitPage){
				$_pagerBuf .= '<li><a href="'.$href.'/page/'.$limitPage.$query.'">'.$limitPage.'</a></li><li><a href="'.$href.'/page/'.$nextPage.$query.'">Вперед »</a></li>';
			}else{
				$_pagerBuf .= '<li>&nbsp;...&nbsp;<a href="'.$href.'/page/'.$limitPage.$query.'">'.$limitPage.'</a></li><li><a href="'.$href.'/page/'.$nextPage.$query.'">Вперед »</a></li>';
			}
		}
		$_pagerBuf .= '</ul>';
		
		return $_pagerBuf;
	}
?>
