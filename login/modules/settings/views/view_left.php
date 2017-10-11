<table cellspacing="0" cellpadding="0" width="100%">
<?php
/*
 * @author ООО "Фабрика проектов"
 * @copyright 2013
 */
$_first_lvl = DB("SELECT * FROM ".$Config['settings']." WHERE `delete`=0 ");
$cnt = count($_first_lvl);
if ($cnt > 0) {
    echo '
    	<tr><td>
    		<div class="plus-all"><img src="img/struct-content-plus.png" alt="+" /></div>
    		<div class="text open_all_plus">Открыть все пункты</div>
    	</td></tr>';    
}
if(isset($_first_lvl[0]['id']))
	foreach($_first_lvl as $k => $value) {
		$echo = '
		<tr class="tree_row text-menu">
			<td style="" '.($k % 2 == 0 ? ' class="even"' : '').'>
				%plus%
				<div class="icon">
					<img src="img/struct-content-pagefolder.png" alt="" />
				</div>
				<div class="text">
					'.$value['value'].'
				</div>
				'.icon_draw('delete', $URL.'&action=delete&id='.$value['id'].'&parent=0').'
				'.icon_draw('add', $URL.'&action=add&parent='.$value['id']).'
			</td>
		</tr>';

		$_second_lvl = DB("SELECT * FROM ".$Config['settings_element']." WHERE `id_setting` = ".$value['id']." AND `delete`=0 ORDER BY `sort` ASC");
		if(count($_second_lvl) > 0)
			echo str_replace('%plus%','<div class="plus"><img src="img/struct-content-plus.png" alt="+" /></div>', $echo);
		else
			echo str_replace('%plus%','<div class="plus-empty"></div>', $echo);

		if(isset($_second_lvl[0]['id'])) {
			echo '<tr class="tree_row"><td class="in" id="in"><div><table cellspacing="0" cellpadding="0" width="100%" class="level1">';
			foreach($_second_lvl as $sk => $value2) {
				$_even = (($k + 1 + $sk) % 2 == 0)? ' class="even"' : '';
				echo '
					<tr>
						<td'.$_even.'>
							<div class="plus-empty"></div>
							<div class="icon">
									<a href="'.$URL.'&action=show&id='.$value2['id'].'"><img src="img/struct-content-page.png" alt="" /></a>
							</div>
							<div class="text">
									<a href="'.$URL.'&action=show&id='.$value2['id'].'" title="'.$value2['name'].'">'.$value2['name'].'</a>
							</div>

							'.icon_draw('delete', $URL.'&action=delete&id='.$value2['id'].'&parent='.$value['id']).'
							'.icon_draw('down', $URL.'&action=down&id='.$value2['id']).'
							'.icon_draw('up', $URL.'&action=up&id='.$value2['id']).'
						</td>
					</tr>';
			}
			print '</table></div></td></tr>';
		}
	}

?>

</table>
