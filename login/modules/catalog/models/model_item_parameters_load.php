<?php
	$PARAMETERS = array();
	if($_ID_TREE == 0 && isset($G['id'])) {
		$_id_tree = DB("select `id_tree` from `".$Config['table']['item']."` where `id` = '".$G['id']."' LIMIT 1");
		$_id_tree = $_id_tree[0]['id_tree'];
	}
	elseif($_ID_TREE == 0 && isset($G['into'])) {
		$_id_tree = $G['into'];
	}
	else
		$_id_tree = $_ID_TREE;

	$_id_tree = get_id_p($_id_tree);

	$i = 0;
	$_params_group = DB("select `id`, `title` from `".$Config['table']['tree_params']."` where `id_tree` = '".$_id_tree."' and `id_group` = '0' and `delete` = '0' order by `sort` asc");
	foreach($_params_group as $_params_group_val) {
		$PARAMETERS[$i]['name'] = $_params_group_val['title'];
		$PARAMETERS[$i]['parameters'] = array();
		$_params = DB("select `id`, `title`, `type` from `".$Config['table']['tree_params']."` where `id_tree` = '".$_id_tree."' and `id_group` = '".$_params_group_val['id']."' and `delete` = '0' order by `sort` asc");
		$j = 0;
		foreach($_params as $_params_val) {
			$_value='';
			if(isset($G['id'])){
				$res=DB("select `value` from `".$Config['table']['item_params']."` where `id_item` = '".$G['id']."' and `id_parameter` = '".$_params_val['id']."' limit 1");
				if(isset($res[0]['value']) && $res[0]['value']!==''){
					$_value=$res[0]['value'];	
				}
				else $_value='';
			}
			else $_value='';
			$PARAMETERS[$i]['parameters'][$j]['id'] = $_params_val['id'];
			$PARAMETERS[$i]['parameters'][$j]['name'] = $_params_val['title'];
			$PARAMETERS[$i]['parameters'][$j]['type'] = (int)$_params_val['type'];
			$PARAMETERS[$i]['parameters'][$j]['value'] = $_value;
			$j++;
		}
		$i++;
	}
	unset($_params,$_params_group,$_params_val,$_params_group_val,$_id_tree,$_value);
?>
