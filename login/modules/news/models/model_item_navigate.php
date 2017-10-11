<?php
	$WHERE = '';
	if ($action == 'n-active'){
		$WHERE= "and `active`='0'";
	}
	if(isset($_GET['orderby']) && !empty($_GET['orderby'])){
		SaveVal($_GET,array('orderby'),array('STRING_ADDSL'),'_');
	} else{
		$_orderby = 'default';
		$class = '';
	}
	$ORDERBY = 'order by `id_tree` asc, `date` desc';
	switch($_orderby){
		case 'check_desc':
			$ORDERBY = 'order by `check` desc, `date` desc';
			$class = 'not-be-sortable';
			break;	
		default:
			$ORDERBY = 'order by `id_tree`, `date` desc';
			$class = '';
			break;	
	}
	$_ID_TREE = (isset($_GET['id_tree']) && intval($_GET['id_tree'] > 0)) ? (int)$_GET['id_tree'] : 0;
	$_PAGE = (isset($_GET['page']) && intval($_GET['page'] > 0)) ? (int)$_GET['page'] : 1;
	$_TOTAL_PAGE = 0;
	$_COUNT_PER_PAGE = (isset($_COOKIE['count']) && (int)$_COOKIE['count']>0) ? $_COOKIE['count'] : (int)$Config['common']['count_per_page'];
	$_TOTAL_COUNT = 0;
	$_ITEMS = array();
	$_QUERY = $URL.'&action='.$action.'&id_tree='.$_ID_TREE;
	$_buff = '';

	if($_ID_TREE == 0) { // all item list
		$_ITEMS = DB("select * from `".$Config['table']['item']."` where `delete` = '0' ".$WHERE." ".$ORDERBY." limit  ".$_COUNT_PER_PAGE * ($_PAGE - 1).",".$_COUNT_PER_PAGE);
		$_TOTAL_COUNT = count(DB("SELECT `id` from `".$Config['table']['item']."` where `delete` = 0 ".$WHERE));
		$_right_title = 'Все новости';
	} else { // only this tree items
		$_ITEMS = DB("select * from `".$Config['table']['item']."` where `delete` = 0 ".$WHERE." and `id_tree` = '".$_ID_TREE."' ".$ORDERBY." limit ".$_COUNT_PER_PAGE * ($_PAGE - 1).",".$_COUNT_PER_PAGE);
		$_TOTAL_COUNT = count(DB("SELECT `id` from `".$Config['table']['item']."` where `delete` = 0 ".$WHERE." and `id_tree` = ".$_ID_TREE));
		$_tree = getInfo($_ID_TREE, $Config['table']['tree'], '`title`');
		$_right_title = 'Новости раздела <strong>'.$_tree['title'].'</strong>';
	}

	$_TOTAL_PAGE = ($_TOTAL_COUNT % $_COUNT_PER_PAGE == 0) ? $_TOTAL_COUNT / $_COUNT_PER_PAGE : ((int)($_TOTAL_COUNT / $_COUNT_PER_PAGE) + 1);
	
	for($i = 0, $cnt = count($_ITEMS); $i < $cnt; $i++){
		$tmpImg = DB("select `fname` from `".$Config['table']['item_images']."` where `id_item`= '".$_ITEMS[$i]['id']."' order by `primary` desc, `sort` asc limit 0, 1");
		if(!empty($tmpImg) && file_exists($Config['dir']['data_dir'].'cms_small/'.$tmpImg[0]['fname'])){
			$_ITEMS[$i]['img'] = $tmpImg[0]['fname'];
		} else $_ITEMS[$i]['img'] = $Config['common']['no_photo'];
		
		if($_ITEMS[$i]['active'] != '1'){
			$opacity = 'style="opacity: 0.5;"';
		} else $opacity = '';
		$_date = '<span>Дата публикации: <strong>'.date('d.m.Y в H:i', $_ITEMS[$i]['date']).'</strong></span>&nbsp;&nbsp;&nbsp;&nbsp;';
		$_changed = '<span>Последнее изменение: <strong>'.date('d.m.Y в H:i:s', $_ITEMS[$i]['changed']).'</strong></span>';
		$_buff .= '<tr '.$opacity.' href="'.$URL.'&action=item_edit&id='.$_ITEMS[$i]['id'].'">
					<td class="checkbox"><img src="img/struct-content-check.png"><input type="hidden" name="checkbox['.$_ITEMS[$i]['id'].']" value="0"></td>
					<td class="item">
						<div class="padding">
							<span>'.(($i+1)+$_COUNT_PER_PAGE*($_PAGE-1)).'</span>
						</div>
					</td>
					<td class="item"><div class="img-container"><div class="img" style="background-image: url(\''.$Config['dir']['data_dir'].'cms_small/'.$_ITEMS[$i]['img'].'\');"></div></div></td>
					<td class="item">'.$_ITEMS[$i]['title'].'</td>
					<td class="item item-desc">'.opt_draw($_ITEMS[$i], $_QUERY).$_date.$_changed.'</td>
				</tr>';
	}
?>
