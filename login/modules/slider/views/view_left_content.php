<table cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td>
            <a class="btn" id="append_tree_0" href="<?php echo $URL.'&action=blank'; ?>"><i class="icon-plus-sign"></i> Добавить новый слайдер</a>
	   </td>
    </tr>
<?php
    $_second_lvl = DB("SELECT `id` FROM `".$Config['slider']."` WHERE `parent` > 0 AND `delete` = 0");
    $cnt = count($_second_lvl);
    if ($cnt > 0) {
        echo '
        	<tr><td>
        		<div class="plus-all"><img src="img/struct-content-plus.png" alt="+" /></div>
        		<div class="text open_all_plus">Открыть все пункты</div>
        	</td></tr>';    
    }
	


$_first_lvl = DB("SELECT `id`, `parent`, `title`, `active` FROM ".$Config['slider']." WHERE `parent` = 0 AND `delete`=0 ORDER BY `sort` ASC");
if(isset($_first_lvl[0]['id']))
	foreach($_first_lvl as $k => $value) {
		$echo = '
		<tr class="tree_row">
			<td style="" '.($k % 2 == 0 ? ' class="even"' : '').'>
				%plus%
				<div class="icon">
					<a href="'.$URL.'&action=show&id='.$value['id'].'&slider=1"><img src="img/struct-content-pagefolder.png" alt="" /></a>
				</div>
				<div class="text">
					<a href="'.$URL.'&action=show&id='.$value['id'].'&slider=1" title="'.$value['title'].'">'.$value['title'].'</a>
				</div> 
				'.icon_draw('delete', $URL.'&action=delete&id='.$value['id']).'
				'.icon_draw(array('check' => $value['active']), $URL.'&action=active&id='.$value['id']).'
				'.icon_draw('add', $URL.'&action=add&parent='.$value['id']).'
				'.icon_draw('down', $URL.'&action=down&id='.$value['id']).'
				'.icon_draw('up', $URL.'&action=up&id='.$value['id']).'
			</td>
		</tr>';

		$_second_lvl = DB("SELECT `id`, `parent`, `title`, `active` FROM `".$Config['slider']."` WHERE `parent` = ".$value['id']." AND `delete`=0 ORDER BY `sort` ASC");
		if(count($_second_lvl) > 0)
			echo str_replace('%plus%','<div class="plus"><img src="img/struct-content-plus.png" alt="+" /></div>', $echo);
		else
			echo str_replace('%plus%','<div class="plus-empty"></div>', $echo);
		if(isset($_second_lvl[0]['id'])) {
			echo '<tr  class="tree_row"><td class="in" id="in"><div><table cellspacing="0" cellpadding="0" width="100%" class="level1">';
			foreach($_second_lvl as $sk => $value2) {
				$_even = (($k + 1 + $sk) % 2 == 0)? ' class="even"' : '';
				echo '
					<tr>
						<td'.$_even.'>
							<div class="plus-empty"></div>
							<div class="icon">
									<a href="'.$URL.'&action=show&id='.$value2['id'].'&slider=0"><img src="img/struct-content-page.png" alt="" /></a>
							</div>
							<div class="text">
									<a href="'.$URL.'&action=show&id='.$value2['id'].'&slider=0" title="'.$value2['title'].'">'.$value2['title'].'</a>
							</div>

							'.icon_draw('delete', $URL.'&action=delete&id='.$value2['id']).'
							'.icon_draw(array('check' => $value2['active']), $URL.'&action=active&id='.$value2['id']).'
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