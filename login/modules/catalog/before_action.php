<?php
function saveImage($fname){
	global $Config;
	$file = $Config['dir']['tmp_dir'].$fname;
	if (file_exists($file)){
		for ($i = 0, $cnt = count($Config['dir']['img']); $i < $cnt; $i++){
			$newfile = $Config['dir']['data_dir'].$Config['dir']['img'][$i]['dir'];
			if (!file_exists($newfile)){
				mkdir($newfile);
			}
			image_resize(
				$file,
				$newfile.$fname,
				$Config['dir']['img'][$i]['width'],
				$Config['dir']['img'][$i]['height'],
				$Config['dir']['img'][$i]['fit'],
				$Config['dir']['img'][$i]['scale']
			);
		}
		unlink($file);
	}
}
function unlinkImage($fname){
	global $Config;
	if (trim($fname) != ''){
		for ($i = 0, $cnt = count($Config['dir']['img']); $i < $cnt; $i++){
			$file = $Config['dir']['data_dir'].$Config['dir']['img'][$i]['dir'].$fname;
			if (file_exists($file)){
				unlink($file);
			}
		}
	}
}
function checkDir(){
	global $Config;
	for($i = 0, $cnt = count($Config['dir']['img']); $i < $cnt; $i++){
		$dir = $Config['dir']['data_dir'].$Config['dir']['img'][$i]['dir'];
		if(!file_exists($dir)){
			mkdir($dir);
			image_resize(
				$Config['common']['no_photo_dir'].$Config['common']['no_photo'],
				$dir.$Config['common']['no_photo'],
				$Config['dir']['img'][$i]['width'],
				$Config['dir']['img'][$i]['height'],
				$Config['dir']['img'][$i]['fit'],
				$Config['dir']['img'][$i]['scale']
			);
		} else continue;
	}
}
function getTree($LVL, $lvl = 0, $odd = 1, $width = 210) {
	global $URL, $Config;
	$buf = NULL;
	$tmp = NULL;
	$TREE_lvl = DB("select `id`, `title`, `id_tree`, `active` from ".$Config['table']['tree']." where `id_tree` = ".$LVL." AND `delete` = 0 order by `sort` asc");
	if(isset($TREE_lvl[0])) {
		foreach ($TREE_lvl as $k => $TREE_lvl_val) {

			$tmp = getTree($TREE_lvl_val['id'],$lvl+1,$k,$width-16);

			$buf .= '
				<tr class="tree_row">
					<td style="" '.(($odd + 1 + $k) % 2 == 0 ? ' class="even"' : '').'>
						'.($tmp ? '<div class="plus"><img src="img/struct-content-plus.png" alt="+" /></div>' : '<div class="plus-empty"></div>').'
						<div class="icon">
								<a href="'.$URL.'&action=item_navigate&id_tree='.$TREE_lvl_val['id'].'"><img src="img/struct-content-pagefolder.png" alt="" /></a>
						</div>
						<div class="text" style="width:'.$width.'px;">
								<a href="'.$URL.'&action=item_navigate&id_tree='.$TREE_lvl_val['id'].'" title="'.$TREE_lvl_val['title'].'">'.$TREE_lvl_val['title'].'</a>
						</div>
						'.icon_draw('delete', $URL.'&action=tree_delete&id='.$TREE_lvl_val['id']).'
						'.icon_draw(array('check' => $TREE_lvl_val['active']), $URL.'&action=tree_active&id='.$TREE_lvl_val['id']).'
						'.icon_draw('add', $URL.'&action=tree_append&into='.$TREE_lvl_val['id']);
						if($Config['section']['parameters']) $buf .= icon_draw('settings', $URL.'&action=parameters_show&id='.$TREE_lvl_val['id']);
						$buf .= icon_draw('up', $URL.'&action=tree_up&id='.$TREE_lvl_val['id']).'
						'.icon_draw('down', $URL.'&action=tree_down&id='.$TREE_lvl_val['id']).'
						<div class="edit" id="edit"><a href="'.$URL.'&action=tree_edit&id='.$TREE_lvl_val['id'].'" title="Редактировать"><img src="img/struct-content-edit.png" alt="+" /></a></div>
					</td>
				</tr>';

			if($tmp)
				$buf .= '
					<tr  class="tree_row">
						<td class="in" id="in">
							<div>
								<table cellspacing="0" cellpadding="0" width="100%" class="level'.($lvl == 0 ? '' : $lvl).'">
									'.$tmp.'
								</table>
							</div>
						</td>
					</tr>';
		}
	}
	return $buf;
}
function get_tree($_id_tree, $str_id) {
	global $Config;
	$_string = "`".$str_id."` = ".$_id_tree." or ";
	$_tree = DB("select `id` FROM `".$Config['table']['tree']."` where `id_tree` = ".$_id_tree);
	if(count($_tree) > 0) {
		foreach($_tree as $_tree_val)
			$_string .= get_tree($_tree_val['id'],$str_id);
	}
	return $_string;
}
function getInfo($id, $table , $info='*'){
	$res = DB("select ".$info." from `".$table."` where `id` = '".$id."' limit 1");
	return $res[0];
}
function set_active($arr){
	global $Config;
	foreach($arr as $id => $val){
		if($val == 1){
			DB("update `".$Config['table']['item']."` set `active` = '1', `changed` = '".time()."' where `id` = ".$id);
		}
		else continue;
	}
}
function set_not_active($arr){
	global $Config;
	foreach($arr as $id => $val){
		if($val == 1){
			DB("update `".$Config['table']['item']."` set `active` = '0', `changed` = '".time()."' where `id` = ".$id);
		}
		else continue;
	}
}
function set_delete($arr){
	global $Config;
	foreach($arr as $id => $val){
		if($val == 1){
			if($Config['common']['move_to_trash']){
				DB("update `".$Config['table']['item']."` set `delete` = '1', `changed` = '".time()."' where `id` = ".$id);
			} else {
				$tmpImg = DB("select `fname` from `".$Config['table']['item_images']."` where `id_item` = ".$id);
				foreach($tmpImg as $file){
					unlinkImage($file['fname']);
				}
				$f = DB("select `fname` from `".$Config['table']['item']."` where `id` = ".$id);
				if(!empty($f[0]['fname'])){
					unlink($Config['dir']['data_dir'].$f[0]['fname']);
				}
				DB("delete from `".$Config['table']['item']."` where `id` = ".$id);
				DB("delete from `".$Config['table']['item_images']."` where `id_item` = ".$id);
				DB("delete from `".$Config['table']['item_params']."` where `id_item` = ".$id);
			}
		}
		else continue;
	}
}
function get_id($current_id, $count = 0) {
    global $Config;
    $_count = DB("select count(`id`) as `count`, (select `title` from `".$Config['table']['tree']."` where `id` = ".$current_id.") as `title` from `".$Config['table']['tree_params']."` where `id_tree` = ".$current_id);
    if(isset($_count[0]) && (int)$_count[0]['count'] > 0) {
        return array($current_id,$_count[0]['title']);
    }
    elseif(++$count < 100) {
        $_parent = DB("select `id_tree` from `".$Config['table']['tree']."` where `id` = ".$current_id);
        if(isset($_parent[0]) && (int)$_parent[0]['id_tree'] > 0)
            return get_id($_parent[0]['id_tree'],$count);
        else
            return array('0','');
    }
}
function get_id_p($current_id, $count = 0) {
	global $Config;
	$_count = DB("select count(`id`) as `count` from `".$Config['table']['tree_params']."` where `id_tree` = ".$current_id);
	if(isset($_count[0]) && (int)$_count[0]['count'] > 0) {
		return $current_id;
	}
	elseif(++$count < 100) {
		$_parent = DB("select `id_tree` from `".$Config['table']['tree']."` where `id` = ".$current_id);
		if(isset($_parent[0]) && (int)$_parent[0]['id_tree'] > 0)
			return get_id_p($_parent[0]['id_tree'],$count);
		else
			return 0;
	}
}
function opt_draw($item, $query){
	global $Config;
	$_output = '<ul class="item-opt">';
	if($Config['section']['available']){ if($item['available'] == '1') $_output .= '<li><a data-original-title="Есть в наличии" data-placement="bottom" href="'.$query.'&orderby=available_desc"><img src="img/opt_available.png" alt="?!"></a></li>'; else $_output .= '<li><a data-original-title="Нет в наличии" data-placement="bottom" href="'.$query.'&orderby=available_asc"><img src="img/opt_available_false.png" alt="?!"></a></li>'; }
	if($Config['section']['featured']){ if($item['featured'] == '1') $_output .= '<li><a data-original-title="Рекомендуемый товар" data-placement="bottom" href="'.$query.'&orderby=featured_desc"><img src="img/opt_featured.png" alt="?!"></a></li>'; }#else $_output .= '<li><a data-original-title="Рекомендуемый товар(Опция не установлена)" data-placement="bottom" href="'.$query.'&orderby=featured_asc"><img src="img/opt_empty.png" alt="?!"></a></li>'; }
	if($Config['section']['special']){ if($item['special'] == '1') $_output .= '<li><a data-original-title="Специальное предложение" data-placement="bottom" href="'.$query.'&orderby=special_desc"><img src="img/opt_special.png" alt="?!"></a></li>'; }#else $_output .= '<li><a data-original-title="Специальное предложение(Опция не установлена)" data-placement="bottom" href="'.$query.'&orderby=special_asc"><img src="img/opt_empty.png" alt="?!"></a></li>'; }
	if($Config['section']['discount']){ if($item['discount'] == '1') $_output .= '<li><a data-original-title="Установлена скидка" data-placement="bottom" href="'.$query.'&orderby=discount_desc"><img src="img/opt_discount.png" alt="?!"></a></li>'; }#else $_output .= '<li><a data-original-title="Скидка(Опция не установлена)" data-placement="bottom" href="'.$query.'&orderby=discount_asc"><img src="img/opt_empty.png" alt="?!"></a></li>'; }
	#if($item['active'] == '1') $_output .= '<li><a data-original-title="Отображается на сайте" data-placement="bottom" href="'.$query.'&orderby=active_desc"><img src="img/opt_active.png" alt="?!"></a></li>'; else $_output .= '<li><a data-original-title="Не отображается на сайте" data-placement="bottom" href="'.$query.'&orderby=active_asc"><img src="img/opt_active_false.png" alt="?!"></a></li>';
	$_output .= '</ul>';
	return $_output;
}
$_right_title = '';
$_right_content = '';

if(!isset($_COOKIE['cc']) || (int)$_COOKIE['cc'] != 1){
	checkDir();
	setcookie('cc',1);
}
?>
