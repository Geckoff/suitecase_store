<?php
/*
 * @author ООО "Фабрика проектов"
 * @copyright 2013
 */
 	include_once dirname(__FILE__)."/functions/catalog.php";
 	//Глобальные переменные модуля "Каталог"
	$_catalog_url = getStructByID($ClientConfig['page_catalog'], '`name`'); // URL страницы "Каталог"
	$_catalog_url = $ClientConfig['HOST'].'/'.$_catalog_url[0]['name'];
	// id корневого раздела
	$ClientConfig['catalog_root'] =  getRelation($ClientConfig['page_catalog']);
	
	$_cart_url = getStructByID($ClientConfig['page_cart'], '`name`'); // URL страницы "Каталог"
	
	//Глобальные переменные модуля "Новости"
	$_news_url = getStructByID($ClientConfig['page_news'], '`name`'); // URL страницы "Новости"
	if(!empty($_news_url[0]['name'])){
		$_news_url = $ClientConfig['HOST'].'/'.$_news_url[0]['name'];
	}
	// id корневого раздела
	$ClientConfig['news_root'] =  getRelation($ClientConfig['page_news']);
	
	$_cart_url = $ClientConfig['HOST'].'/'.$_cart_url[0]['name'];
		
	//Получаем URL текущей страницы ( Для установки limit и orderby)
	$CURRENT = $ClientConfig['HOST'].'/';
	if(isset($_GET['pages']) && !empty($_GET['pages'])){
		$CURRENT .= $_GET['pages'];
	}
	$CURRENT .= '?';
	if(isset($_GET['q']) && !empty($_GET['q'])){
		$CURRENT .= 'q='.$_GET['q'];
	}
	
	// Menu
	$TMENU = buildMenu($ClientConfig['menu']);
	$tMenubuf =  '<ul><li><a class="all-items-mobile" href="#product-menu">Категории товаров</a></li>';
	for($i = 0, $cnt = count($TMENU); $i < $cnt; $i++){
		if(isset($PAGE['page']['id']) && $TMENU[$i]['id_page'] == $PAGE['page']['id']) $_cl = 'class="active"'; else $_cl = '';
		$tMenubuf .= '<li '.$_cl.'><a href="'.$TMENU[$i]['link'].'">'.$TMENU[$i]['title'].'</a></li>';
	}
	$tMenubuf .= '<li><a class="mobile-cart" style="display: none" href="/cart">Корзина</a></li></ul>';
	
	// Address block
	$_mobile_list = getListSettingsByParent($ClientConfig['mobile']);
	
	// Блок "Наши контакты"
	$ADDRESSES = DB("select `id`,`value` as `title` from `".$TABLE['settings']."` where `delete` = '0'");
	for($i = 0, $cnt = count($ADDRESSES); $i < $cnt; $i++){
		$rows = DB("select `value` from `".$TABLE['settings_element']."` where `id_setting` = '".$ADDRESSES[$i]['id']."' and `delete` = '0'");
		if(!empty($rows)){
				$ADDRESSES[$i]['elements'] = $rows;

		} else unset($ADDRESSES[$i]);
	}
	$ADDRESSES = array_values($ADDRESSES);

	// Блок "Спецпредложение"
	$specialBuf = '';
	$treeChild = getAllTree($TABLE['catalog_tree'], $ClientConfig['catalog_root']);
	$where = $having = "";
	$where = "WHERE `".$TABLE['catalog_item']."`.`id_tree` IN (".$ClientConfig['catalog_root'];
	if(isset($treeChild)){
		for($i = 0, $cntTree = count($treeChild); $i < $cntTree; $i++) {
			$where .= ", ".$treeChild[$i]['id'];
		}
	}
	$where .= ") AND `".$TABLE['catalog_item']."`.`special` = 1 AND `".$TABLE['catalog_item']."`.`active` = 1 AND `".$TABLE['catalog_item']."`.`delete` = 0";
	$SPECIAL = DB("SELECT `id`,`id_tree`,`title`,`url`,`price`,`available`,`discount`,`ds_price` FROM `".$TABLE['catalog_item']."` ".$where." ORDER BY `sort` ASC LIMIT 0, 2");
	unset($where, $treeChild);
	
	for($i = 0, $cnt = count($SPECIAL); $i < $cnt; $i++){
		$img = DB("select `title`, `alt`, `fname` from `".$TABLE['catalog_img']."` where `id_item` = '".$SPECIAL[$i]['id']."' order by `primary` desc, `sort` asc limit 0, 1");
		if(!isset($img[0]['fname']) || empty($img[0]['fname'])){
			$SPECIAL[$i]['img'][0]['fname'] = 'no-photo.jpg';
		}else {
			$SPECIAL[$i]['img'][0]['fname'] = $img[0]['fname'];
		}
		$category = getUrlTree($TABLE['catalog_tree'], $SPECIAL[$i]['id_tree'], $ClientConfig['catalog_root']);
		$category[]['url'] = $_catalog_url;
		$tmp_cat = '';
		for($cntCat = count($category), $j = $cntCat -1; $j >= 0; $j--){
			$tmp_cat .= $category[$j]['url'].'/';
		}
		$SPECIAL[$i]['url'] = $tmp_cat.$SPECIAL[$i]['url'];
		$_cl = $prBuf = '';
		if($SPECIAL[$i]['discount'] == 1 && $SPECIAL[$i]['price']){
			$oldPriceBuf ='<span class="old-price"><strike>'.number_format($SPECIAL[$i]['price'],0,"."," ").' руб</strike></span>';
		}else{
			$oldPriceBuf = '<span>&nbsp;</span>';
		}
		if($SPECIAL[$i]['ds_price'] != 0) $prBuf = '<span class="price">'.number_format($SPECIAL[$i]['ds_price'],0,"."," ").'<small> руб</small></span>'; else $prBuf = '<span>Уточняйте стоимость</span>';
		if($SPECIAL[$i]['available'] == 0) $_btnClass = 'disabled'; else $_btnClass = 'add-to-cart';
		$specialBuf .='<div class="block"><div class="block-content special">
					<a class="title" href="'.$SPECIAL[$i]['url'].'" title="'.$SPECIAL[$i]['title'].'">'.$SPECIAL[$i]['title'].'</a>
					<a class="product-img" href="'.$SPECIAL[$i]['url'].'" title="'.$SPECIAL[$i]['title'].'">
						<div>
							<img src="'.$ClientConfig['DATA_URL'].'/catalog/small/'.$SPECIAL[$i]['img'][0]['fname'].'" alt=""/>
						</div>
					</a>
					<div class="product-info clearfix">
						'.$prBuf.'
						'.$oldPriceBuf.'
					</div>
					<a class="more btn" href="'.$SPECIAL[$i]['url'].'" title="Подробнее о '.$SPECIAL[$i]['title'].'">Подробнее</a>
					<a class="'.$_btnClass.' btn btn-red" href="#" title="Купить" data-product-id="'.$SPECIAL[$i]['id'].'">Купить<span class="add"></span></a>
				</div></div>';
	}

    // Блоки
    $FIXED_BLOCK = getBlockByID($ClientConfig['fixed_block'], '`content`');
    $LEFT_BLOCK = getBlockByID($ClientConfig['left_block'], '`content`');
    $TOP_BLOCK = getBlockByID($ClientConfig['top_block'], '`content`');
    $CONTACTS_BLOCK = getBlockByID($ClientConfig['contacts_block'], '`content`');
    
    
?>
