<?php
	ob_start();
	include get('model_tree_edit');
	include get('view_tree');
	$_right_content = ob_get_contents();
	ob_end_clean();
?>
