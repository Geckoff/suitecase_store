<?php
	$__STRUCT = getStruct($G['id']);
	$__RELATION = getRelation($G['id']);
	
	if (isset($__RELATION[0]))
	{
		getModuleRelation($__RELATION);
	}
?>