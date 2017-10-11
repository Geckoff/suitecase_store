<?php
	$PARAMETERS = array();
	$_id_array = get_id($G['id']);
	$_id = $_id_array[0];
	if((int)$_id > 0) {
	   $_SESSION['info'] = ($_id != $G['id'] ? 'Параметры унаследованы от раздела <strong>'.$_id_array[1].'</strong><br/><a href="#" class="link" onclick="delete_inherited_param(); return false;">Удалить унаследованные параметры</a>' : '');
	   $_group = DB("select `id`, `title`, `type`, `active`, `delete` from `".$Config['table']['tree_params']."` where `id_tree` = '".$_id."' and `id_group` = '0' and `delete` = '0' order by `sort` asc");
	   $i = 0;
	   if(isset($_group[0]))
		   foreach($_group as $_group_val) {
				$PARAMETERS[$i] = array();
				$PARAMETERS[$i]['id'] = $_group_val['id']; //?? $_group_val['id'];
				$PARAMETERS[$i]['name'] = $_group_val['title'];
				$PARAMETERS[$i]['active'] = $_group_val['active'];
				$PARAMETERS[$i]['delete'] = $_group_val['delete'];
				$_params = DB("select `id`, `title`, `type`, `active`, `delete` from `".$Config['table']['tree_params']."` where `id_tree` = '".$_id."' and `id_group` = '".$_group_val['id']."' and `delete` = '0' order by `sort` asc");
				$j = 0;
				foreach($_params as $_params_val) {
					$PARAMETERS[$i]['parameters'][$j]['id'] = $_params_val['id']; //?? $_params_val['id'];
					$PARAMETERS[$i]['parameters'][$j]['title'] = $_params_val['title'];
					$PARAMETERS[$i]['parameters'][$j]['type'] = $_params_val['type'];
					$PARAMETERS[$i]['parameters'][$j]['active'] = $_params_val['active'];
					$PARAMETERS[$i]['parameters'][$j]['delete'] = $_params_val['delete'];
					$j++;
				}
		   $i++;
		   }
	}
	unset($_id_array, $i, $j, $_group, $_params, $_values);
?>
