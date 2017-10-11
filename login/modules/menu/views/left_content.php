<div id="left">
    <div id="left-menu-form">
        <form action="<?php echo $URL,'&action=add_menu';?>" method="POST">
            <div class="add_menu">Добавить новое меню </div>
            <div class="under_title">
                <input type="text" name="menu_name" />
                <input class="btn" type="submit" value="Сохранить" />
            </div>
        </form>
    </div>
    <table cellspacing="0" cellpadding="0" width="100%">
        <?php
        if(isset($all_left_menus)&&!empty($all_left_menus)){
        foreach($all_left_menus as $k => $menu){
        ?>
        <tr>
            <td style="padding-left:15px;" <?php echo ($k % 2 == 0)? ' class="even"' : ''; ?>>
                <div class="icon"><a href="<?php echo $URL,'&action=show_elements&id=',$menu['id'] ?>"><img src="img/struct-content-page.png" alt="" /></a></div>
                <div class="text"><a href="<?php echo $URL,'&action=show_elements&id=',$menu['id'] ?>"><?php echo $menu['title'];?></a></div>
                <?php
                    echo icon_draw('delete', $URL.'&action=delete_menu&id='.$menu['id']);
                ?>
            </td>
        </tr>
        <?php }
		}
		else{
			echo'<tr></tr>';
		}
?>
    </table>
</div>
