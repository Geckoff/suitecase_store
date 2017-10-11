<?php
	foreach($P['groups'] as $_group_val) {
		$_last_id = NULL;
		if((int)$_group_val['id'] > 0){ // change group
			DB("update `".$Config['table']['tree_params']."` set `title` = '".$_group_val['name']."', `url` = '".translit($_group_val['name'])."-".$_group_val['id']."', `active` = '".(int)$_group_val['active']."', `delete` = '".(int)$_group_val['delete']."' where `id` = ".$_group_val['id']);
			$_last_id = $_group_val['id'];
			foreach($_group_val['parameters'] as $_parameters_val) {
				if($_parameters_val['id'] == '' && $_parameters_val['delete'] == '0') { //insert new parameter
					DB("insert into `".$Config['table']['tree_params']."` (`id_tree`, `id_group`, `title`, `url`, `type`, `active`, `delete`)
					values (".$G['id'].", '".$_last_id."', '".$_parameters_val['name']."', '', '".$_parameters_val['type']."', '".(int)$_parameters_val['active']."', '".(int)$_parameters_val['delete']."')");
					$_last_id_second = (int)mysql_insert_id();
					$_max_sort = DB("select max(`sort`) as `max` from ".$Config['table']['tree_params']);
					DB("update `".$Config['table']['tree_params']."` set `sort` = ".$_max_sort[0]['max']."+1, `url` = '".translit($_parameters_val['name'])."-".$_last_id_second."' where `id` = ".$_last_id_second);
				}
				else { // change parameter
					DB("update `".$Config['table']['tree_params']."` set `title` = '".$_parameters_val['name']."', `url` = '".translit($_parameters_val['name'])."-".$_parameters_val['id']."', `type` = '".$_parameters_val['type']."', `active` = ".(int)$_parameters_val['active'].", `delete` = ".(int)$_parameters_val['delete']." where `id` = ".$_parameters_val['id']);
				}
			}
		}else if($_group_val['id'] == '' && $_group_val['delete'] == '0') { // insert new group
			DB("insert into `".$Config['table']['tree_params']."` (`id_tree`, `id_group`, `title`, `url`, `type`, `active`, `delete`)
				values ('".$G['id']."', '0', '".$_group_val['name']."', '', '0', '".(int)$_group_val['active']."', '".(int)$_group_val['delete']."')");
			$_last_id = (int)mysql_insert_id();
			$_max_sort = DB("select max(`sort`) as `max` from ".$Config['table']['tree_params']);
			DB("update `".$Config['table']['tree_params']."` set `sort` = ".$_max_sort[0]['max']."+1, `url` = '".translit($_group_val['name'])."-".$_last_id."' where `id` = ".$_last_id);
			foreach($_group_val['parameters'] as $_parameters_val) {
				if($_parameters_val['delete'] == '0') { //insert new parameter
					DB("insert into `".$Config['table']['tree_params']."` (`id_tree`, `id_group`, `title`, `url`, `type`, `active`, `delete`)
					values (".$G['id'].", '".$_last_id."', '".$_parameters_val['name']."', '', '".$_parameters_val['type']."', '".(int)$_parameters_val['active']."', '".(int)$_parameters_val['delete']."')");
					$_last_id_second = (int)mysql_insert_id();
					$_max_sort = DB("select max(`sort`) as `max` from ".$Config['table']['tree_params']);
					DB("update `".$Config['table']['tree_params']."` set `sort` = ".$_max_sort[0]['max']."+1, `url` = '".translit($_parameters_val['name'])."-".$_last_id_second."' where `id` = ".$_last_id_second);
				}else{
					continue;
				}
			}
		}else{
			continue;
		}
	}
?>
