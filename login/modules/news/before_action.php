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
						'.icon_draw('add', $URL.'&action=tree_append&into='.$TREE_lvl_val['id']).'
						'.icon_draw('up', $URL.'&action=tree_up&id='.$TREE_lvl_val['id']).'
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
			}
		}
		else continue;
	}
}
function opt_draw($item, $query){
	global $Config;
	$_output = '<ul class="item-opt">';
	if($item['check'] == '1') $_output .= '<li><a data-original-title="Новость выделена" data-placement="bottom" href="'.$query.'&orderby=check_desc"><img src="img/opt_active.png" alt="?!"></a></li>';
	$_output .= '</ul>';
	return $_output;
}
$_right_title = '';
$_right_content = '';

if(!isset($_COOKIE['cn']) || (int)$_COOKIE['cn'] != 1){
	checkDir();
	setcookie('cn',1);
}
?>
