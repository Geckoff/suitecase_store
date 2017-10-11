<?php
if(isset($_last_id) && !empty($_last_id)){
	if(isset($P['params']['strings'])){ // text parameters
		foreach($P['params']['strings'] as $_selects_param => $_strings_val) {
			$res = DB("select `id` from `".$Config['table']['item_params']."` where `id_parameter`= '".$_selects_param."' and `id_item` = '".$_last_id."' limit 1");
			if(isset($res[0]['id']) && !empty($res[0]['id'])){ //update value
				DB("update `".$Config['table']['item_params']."` set `value` = '".$_strings_val."' where `id_item` = '".$_last_id."' and `id_parameter` = '".$_selects_param."'");
			} else{ //new value
				DB("insert into `".$Config['table']['item_params']."` (`id_item`, `id_parameter`, `value`) values('".$_last_id."', '".$_selects_param."', '".$_strings_val."')");
			}
			unset($res);
		}	
	}
	if(isset($P['params']['checkboxes'])){ // checkboxes 
		foreach($P['params']['checkboxes'] as $_selects_param => $_strings_val) {
			$res = DB("select `id` from `".$Config['table']['item_params']."` where `id_parameter`= '".$_selects_param."' and `id_item` = '".$_last_id."' limit 1");
			if(isset($res[0]['id']) && !empty($res[0]['id'])){ //update value
				DB("update `".$Config['table']['item_params']."` set `value` = '".$_strings_val."' where `id_item` = '".$_last_id."' and `id_parameter` = '".$_selects_param."'");
			} else{ //new value
				DB("insert into `".$Config['table']['item_params']."` (`id_item`, `id_parameter`, `value`) values('".$_last_id."', '".$_selects_param."', '".$_strings_val."')");
			}
			unset($res);
		}	
	}
}
?>
