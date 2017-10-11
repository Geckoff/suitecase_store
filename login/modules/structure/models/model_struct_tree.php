<?php
	function getStructTree($_id_parent) {
		global $Config;
		$__R = DB("SELECT * FROM `".$Config['main_table']."` WHERE `parent` = '".$_id_parent."' AND `delete` = 0 ORDER BY `sort` ASC");
		$_count = count($__R);
		for($i = 0; $i < $_count; $i++)
		{
			$_temp = getStructTree($__R[$i]['id']);
			if (isset($_temp[0]))
				$__R[$i]['child'] = $_temp;
		}
		return $__R;
	}
	$__STRUCT_TREE = getStructTree(0);
?>