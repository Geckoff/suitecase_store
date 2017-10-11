<?php
/*
 * @author ООО "Фабрика проектов"
 * @copyright 2013
 */
    session_start();
	include dirname(__FILE__).'/config/client_start.php';
    include dirname(__FILE__).'/client/functions.php';
    // Глобальные переменные модуля "Каталог"
	$url = getStructByID($ClientConfig['page_catalog'], '`name`'); // URL страницы "Каталог"
	$url = $ClientConfig['HOST'].'/'.$url[0]['name'];
	
	// id корневого раздела
	$root =  getRelation($ClientConfig['page_catalog']);
	
	$cart = json_decode($_POST['cart'], true);
	for($i = 0, $cnt = count($cart); $i < $cnt; $i++){
		$tmp = $category = $tmp_cat = $tImg = '';
		$tmp = DB("SELECT `id_tree`,`title`,`url`,`ds_price` FROM `".$TABLE['catalog_item']."` WHERE `id` = '".$cart[$i]['pid']."' LIMIT 0, 1");
		if(!empty($tmp)){
			$category = getUrlTree($TABLE['catalog_tree'], $tmp[0]['id_tree'], $root);
			$category[]['url'] = $url;
			for($cntCat = count($category), $j = $cntCat -1; $j >= 0; $j--){
				$tmp_cat .= $category[$j]['url'].'/';
			}
			$cart[$i]['url'] = $tmp_cat.$tmp[0]['url'];
			$cart[$i]['title'] = $tmp[0]['title'];
			$cart[$i]['price'] = $tmp[0]['ds_price'];
			$tImg = DB("SELECT `fname` FROM `".$TABLE['catalog_img']."` WHERE `id_item` = '".$cart[$i]['pid']."' ORDER BY `primary` DESC, `sort` ASC LIMIT 0, 1");
			if(!empty($tImg[0]['fname'])){
				$cart[$i]['fname'] = $tImg[0]['fname'];
			}else{
				$cart[$i]['fname'] = 'no-photo.jpg';
			}
		}
	}
	echo json_encode($cart);
?>
