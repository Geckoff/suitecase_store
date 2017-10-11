<?php
    // function getNewsItem($id_item)
    // function getNewsTree($root, $url, $parent = false, $start = false, $end = false, $orderby = '', $search = false)
    // $PID - ID текущего раздела, для inifinity scroll
    // $ROOT - ID "корневого раздела"
    // $URL - url страницы! модуля
    
    include_once dirname(__FILE__)."/functions/news.php";
    
	$OUTPUT = array(); //Переменная для выводна на страницу
	$PID = false;
	$ROOT = 0;
	$URL = $ClientConfig['HOST'];
	
	if(isset($PAGE['module']['id_main_field']) && (int)$PAGE['module']['id_main_field'] > 0){
		$ROOT = &$PAGE['module']['id_main_field'];
	}else{
		$ROOT = 0;
	}
	
	$URL .= '/'.$PAGE['page']['name'];

    $_level_url = getLevelUrl($MODULE_URL, $TABLE['news_item'], $TABLE['news_tree'], $ROOT);
    
	// Количество элементов на страницу
	if(isset($_GET['limit']) && !empty($_GET['limit']) && (int)$_GET['limit'] > 0){
		$_SESSION['limit'] = (int)$_GET['limit'];
	}else if(!isset($_SESSION['limit']) || (int)$_SESSION['limit'] < 0){
		$_SESSION['limit'] = $ClientConfig['count_per_page'];
	}

	// Номер текущей страницы
	if(!isset($_GET['npage'])){
		$NPAGE = 1;
	}else{
		$NPAGE = htmlspecialchars($_GET['npage']);
	}

	// Сортировка
	if(isset($_GET['orderby']) && !empty($_GET['orderby'])){
		$_SESSION['orderby'] = htmlspecialchars($_GET['orderby']);
	}else if(!isset($_SESSION['orderby']) || empty($_SESSION['orderby'])){
		$_SESSION['orderby'] = 'default';
	}

	switch($_SESSION['orderby']){
		default:
			$ORDERBY = "ORDER BY `".$TABLE['news_item']."`.`check` DESC,  `".$TABLE['news_tree']."`.`id_tree` ASC, `".$TABLE['news_tree']."`.`sort` ASC,
					`".$TABLE['news_item']."`.`id_tree` ASC, `".$TABLE['news_item']."`.`date` DESC";
			break;
	}
	
	if($_level_url['level'] == 'item'){ // Страница элемента (id_item = $lvl['id'])
		if(isset($_GET['npage'])){
			$error404 = true;
		}else{
			$OUTPUT = getNewsItem($_level_url['id']);
			if (isset($OUTPUT)){
				$TITLE = $OUTPUT['title'];
				$TEMPLATE = 'news/item.php';
				$META = array('meta_title' => $OUTPUT['seo_title'], 'meta_keywords' => $OUTPUT['seo_keywords'], 'meta_description' => $OUTPUT['seo_description']); 
			}else{
				$error404 = true;
			}
		}
	}else if($_level_url['level'] == 'tree'){ // Страница раздела (id_tree = $lvl['id'])
		$PID = $_level_url['id'];
		$LIMIT = $_SESSION['limit'];
		$TOTAL_COUNT = getNewsTree($ROOT, $URL, $PID, false, false, $ORDERBY);
		$COUNT_PAGES = ceil($TOTAL_COUNT / $LIMIT);
		if($NPAGE != '1' && $NPAGE > $COUNT_PAGES){
			$error404 = true;
		}else{
			$START = ($NPAGE - 1) * $LIMIT;
			$OUTPUT = getNewsTree($ROOT, $URL, $PID, $START, $LIMIT, $ORDERBY);
			if(isset($OUTPUT[0])){
				$TREE_META = @getTreeByID($PID, $TABLE['news_tree'], '`title`, `description`,`seo_title`,`seo_keywords`,`seo_description`');
				if (isset($TREE_META[0])) {
					$TITLE = $TREE_META[0]['title']; 
					$TEXT = $TREE_META[0]['description'];
					$META = array('meta_title' => $TREE_META[0]['seo_title'], 'meta_keywords' => $TREE_META[0]['seo_keywords'], 'meta_description' => $TREE_META[0]['seo_description']); 
				}
				$TEMPLATE = 'news/tree.php';
			}else{
				$TITLE = 'В этом разделе еще нет акций'; 
				$TEXT = 'Выберите другой раздел для просмотра'; 
				$META = array('meta_title' => 'В этом разделе еще нет акций', 'meta_keywords' => 'В этом разделе еще нет акций', 'meta_description' => 'В этом разделе еще нет акций');   
				$TEMPLATE = 'simple.php';
			}
		}
	}else if($_level_url['level'] == 'page'){ // Страница модуля (id_tree = 0)
		if(isset($_GET['q']) && !empty($_GET['q'])) {
			$PID = $ROOT;
			$LIMIT = $_SESSION['limit'];
			$SEARCH = mysql_real_escape_string($_GET['q']);
			$TOTAL_COUNT = getNewsTree($ROOT, $URL, $PID, false, false, $ORDERBY, $SEARCH);
			$COUNT_PAGES = ceil($TOTAL_COUNT/$LIMIT);
			if($NPAGE != '1' && $NPAGE > $COUNT_PAGES){
				$error404 = true;
			}else{
				$START = ($NPAGE - 1 ) * $LIMIT;
				$OUTPUT = getNewsTree($ROOT, $URL, $PID, $START, $LIMIT, $ORDERBY, $SEARCH);
				$META = array(); 
				
				if(isset($OUTPUT[0])){
					$TITLE = 'Результаты поиска';   
					$TEMPLATE = 'news/tree.php';
				} else {
					$TITLE = 'Ничего не найдено'; 
					$TEXT = 'Попробуйте изменить текст запроса поиска'; 
					$META = array('meta_title' => 'Ничего не найдено', 'meta_keywords' => 'Ничего не найдено', 'meta_description' => 'Ничего не найдено'); 
					$TEMPLATE = 'simple.php';
				}
			}     		 
		}else{
			$PID = $ROOT;
			$LIMIT = $_SESSION['limit'];
			$TOTAL_COUNT = getNewsTree($ROOT, $URL, $PID, false, false, $ORDERBY);
			$COUNT_PAGES = ceil($TOTAL_COUNT/$LIMIT);
			if($NPAGE != '1' && $NPAGE > $COUNT_PAGES){
				$error404 = true;
			} else{
				$START = ($NPAGE - 1 )* $LIMIT;
				$OUTPUT = getNewsTree($ROOT, $URL, $PID, $START, $LIMIT, $ORDERBY);
				if(isset($OUTPUT[0])){
					$TREE_META = @getTreeByID($PID, $TABLE['news_tree'], '`title`, `description`,`seo_title`,`seo_keywords`,`seo_description`');
					if (isset($TREE_META[0])) {
						$TITLE = $TREE_META[0]['title']; 
						$TEXT = $TREE_META[0]['description'];
						$META = array('meta_title' => $TREE_META[0]['seo_title'], 'meta_keywords' => $TREE_META[0]['seo_keywords'], 'meta_description' => $TREE_META[0]['seo_description']); 
					}
					$TEMPLATE = 'news/tree.php';
				}else{
					$TITLE = 'В этом разделе еще нет акций'; 
					$TEXT = 'Выберите другой раздел, для просмотра'; 
					$META = array('meta_title' => 'В этом разделе еще нет акций', 'meta_keywords' => 'В этом разделе еще нет акций', 'meta_description' => 'В этом разделе еще нет акций');   
					$TEMPLATE = 'simple.php';
				}
			}
		}
	}else{ // Ошибка 404
		$error404 = true;
	}
?>
