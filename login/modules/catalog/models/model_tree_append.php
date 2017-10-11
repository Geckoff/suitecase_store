<?php
    if(isset ($G['title']) && $G['title'] != '') {
		$url = translit($G['title']);
		$cntUrl = count(DB("select `url` from `".$Config['table']['tree']."` where `url` like '".$url."%'"));
		if($cntUrl > 0){
			$url .= '-'.$cntUrl;
		}
		$sort = DB("select max(`sort`) as `max` from `".$Config['table']['tree']."`");
        DB("insert into	`".$Config['table']['tree']."` (`id_tree`, `sort`, `title`, `url`, `changed`)
			values('".$G['into']."', '".((int)$sort[0]['max'] + 1)."', '".$G['title']."', '".$url."','".time()."')");
    }
?>
