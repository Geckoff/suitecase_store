<table cellspacing="0" cellpadding="0" width="100%">
	<?php
         if(isset($_Pages_list[0]))
            foreach($_Pages_list as $k => $page)
                echo '<tr class="tree_row">
                        <td style="padding-left:15px;" '.($k % 2 == 0 ? ' class="even"' : '').'>
                            <div class="icon">
                                    <a href="'.$URL.'&action=blank"><img src="img/struct-content-page.png" alt="" /></a>
                            </div>
                            <div class="text">
                                    <a href="'.$URL.'&action=blank" title="'.$page['name'].'">'.$page['name'].'</a>
                            </div>
                        </td>
                      </tr>';
        ?>
</table>