<?php
	ob_start();
	include get('model_item_navigate');
	include get('view_item_navigate');
	$_right_content = ob_get_contents();
	ob_end_clean();
?>
