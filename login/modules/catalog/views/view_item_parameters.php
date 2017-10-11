<div class="block">
	<table cellspacing="0" cellpadding="0" class="block" width="100%">
	<?php
		foreach($PARAMETERS as $_params_group_val) {
			echo '<tr><td collspan="2"><span class="param_group">'.$_params_group_val['name'].'</span></td></tr>';
			foreach($_params_group_val['parameters'] as $PARAMS_val) {
				echo '<tr><td class="param text">'.$PARAMS_val['name'].'</td>';
				if($PARAMS_val['type'] == 0){ //text
					echo '<td><input type="text" name="params[strings]['.$PARAMS_val['id'].']" value="'.$PARAMS_val['value'].'"/></td></tr>';
				} else {
					if(!isset($PARAMS_val['value']) || empty($PARAMS_val['value'])){
						$img = 'img/struct-content-check.png';
						$value = 0;
					}else{						
						$img = 'img/struct-content-check-active.png';
						$value = $PARAMS_val['value'];
					}
					echo '<td><img class="check" src="'.$img.'"><input type="hidden" name="params[checkboxes]['.$PARAMS_val['id'].']" value="'.$value.'" /></td></tr>';
				}
			}
		}
	?>
	</table>
</div>
