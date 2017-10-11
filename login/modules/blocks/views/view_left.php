<table cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td>
            <a class="btn" id="append_tree_0" href="<?php echo $URL.'&action=blank'; ?>"><i class="icon-plus-sign"></i> Добавить новый блок</a>
	   </td>
    </tr>
	<?php
         if(isset($_Pages_list[0]))
            foreach($_Pages_list as $k => $page)
                echo '<tr class="tree_row">
                        <td style="padding-left:15px;" '.($k % 2 == 0 ? ' class="even"' : '').'>
                            <div class="icon">
                                    <a href="'.$URL.'&action=blocks_edit&id='.$page['id'].'"><img src="img/struct-content-page.png" alt="" /></a>
                            </div>
                            <div class="text">
                                    <a href="'.$URL.'&action=blocks_edit&id='.$page['id'].'" title="'.$page['name'].'">'.$page['name'].'</a>
                            </div>
                            '.icon_draw('delete', $URL.'&action=blocks_delete&id='.$page['id']).'
                            '.icon_draw(array('check' => $page['active']), $URL.'&action=blocks_active&id='.$page['id']).'
                        </td>
                      </tr>';
        ?>
</table>