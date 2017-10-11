<script>
$(function(){
	$('div#structLayout').css('width', '100%');
});
</script>
<table cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td>
            <a class="btn" id="append_tree_0" href="<?php print $URL.'&action=blank'; ?>"><i class="icon-plus-sign"></i> Добавить новую страницу</a>
	   </td>
    </tr>
<?php
/*
 * @author ООО "Фабрика проектов"
 * @copyright 2013
 */
    $cnt = count($__STRUCT_TREE);
    if ($cnt > 0) {
        echo '
        	<tr><td>
        		<div class="plus-all"><img src="img/struct-content-plus.png" alt="+" /></div>
        		<div class="text open_all_plus">Открыть все пункты</div>
        	</td></tr>';    
    }
	
	function makeStructTree(&$__R, $_level = 0)
	{
		global $URL;
		$_count = count($__R);
		$_temp = '';
		for($i = 0; $i < $_count; $i++)
		{
			$_even = ($i % 2 == 0)? ' class="even"' : '';
			if (isset($__R[$i]['child'])) {
				$_plus = '<div class="plus"><img src="img/struct-content-plus.png" alt="+" /></div>';
				$_icon = 'pagefolder';
				$_child = '<tr class="tree_row"><td class="in" id="in"><div><table cellspacing="0" cellpadding="0" width="100%" class="level'.($_level+1).'">' . makeStructTree($__R[$i]['child'], $_level + 1) . '</table></div></td></tr>';
			}
			else {
				$_plus = '<div class="plus-empty"></div>';
				$_icon = 'page';
				$_child = '';
			}
			$_temp .= '<tr class="tree_row">
					<td'.$_even.'>
						'.$_plus.'
						<div class="icon">
							<a href="'.$URL.'&action=edit&id='.$__R[$i]['id'].'"><img src="img/struct-content-'.$_icon.'.png" alt="" /></a>
						</div>
						<div class="text">
							<a href="'.$URL.'&action=edit&id='.$__R[$i]['id'].'" title="'.$__R[$i]['menu_title'].'">'.$__R[$i]['menu_title'].'</a>
						</div>
						'.icon_draw('delete', $URL.'&action=delete&id='.$__R[$i]['id']).'
						'.icon_draw(array('check' => $__R[$i]['active']), $URL.'&action=active&id='.$__R[$i]['id']).'
						'.icon_draw('add', $URL.'&action=substruct&id='.$__R[$i]['id']).'
						'.icon_draw('down', $URL.'&action=down&id='.$__R[$i]['id']).'
						'.icon_draw('up', $URL.'&action=up&id='.$__R[$i]['id']).'
					</td>
				</tr>' . $_child;
		}
		return $_temp;
	}
	
	if(isset($__STRUCT_TREE[0]))
	{
		print makeStructTree($__STRUCT_TREE);
	}

	?>
</table>