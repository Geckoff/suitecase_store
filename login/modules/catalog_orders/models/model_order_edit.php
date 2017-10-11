<?php
	$res = DB("select * from `".$Config['catalog_orders']."` where `id` = ".$G['id']);
	if($res[0]['state'] == '2'){
		DB("update `".$Config['catalog_orders']."` set `state` = '0' where `id` = ".$G['id']);
		$state = '0';
	} else $state = $res[0]['state'];
	$ORDER = $res[0];
	$ORDER['state'] = $state;
	switch($state){
		case '1': $ORDER['state-text'] = 'Выполненный'; break;
		case '-1': $ORDER['state-text'] = 'Отмененный'; break;
		default: $ORDER['state-text'] = 'Необработанный'; break;
	}
	$ORDER['date'] = date('d-m-Y в H:i',$ORDER['date']);
	$ORDER['price']=number_format($ORDER['price'],0,"."," ");
	$res = DB("select `".$Config['struct']."`.`name` 
			   from `".$Config['modules']."` inner join `".$Config['struct_relations']."`
			   on `".$Config['modules']."`.`id` = `".$Config['struct_relations']."`.`id_module`
			   inner join `".$Config['struct']."`
			   on `".$Config['struct_relations']."`.`id_struct` = `".$Config['struct']."`.`id`
			   where `".$Config['modules']."`.`name` = 'catalog'");
	$ORDER['catalog_url'] = $AdminConfig['HOST'].'/'.$res[0]['name'];
	$ORDER['products'] = DB("select `".$Config['catalog_item']."`.`id` as `id_product`,
									`".$Config['catalog_item']."`.`id_tree`,
									`".$Config['catalog_item']."`.`title`,
									`".$Config['catalog_item']."`.`url`,
									`".$Config['catalog_item']."`.`ds_price`,
									`".$Config['catalog_orders_products']."`.`count`
							from `".$Config['catalog_item']."` inner join `".$Config['catalog_orders_products']."`
							on `".$Config['catalog_item']."`.`id` = `".$Config['catalog_orders_products']."`.`id_product`
							where `".$Config['catalog_orders_products']."`.`id_order` = ".$G['id']);
	for($i = 0, $cnt = count($ORDER['products']); $i < $cnt; $i++){
		$ORDER['products'][$i]['category'] = getUrlTree($ORDER['products'][$i]['id_tree'], $Config['catalog_tree']);
	}
	
	unset($res,$state);
?>
