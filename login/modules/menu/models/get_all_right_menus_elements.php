<?php
    if(isset($G['id'])) {
        $menu_elements = DB("SELECT * FROM `".$Config['menu_elements']."` WHERE `id_menu`='".$G['id']."' AND `delete`=0");
        $pages_from_struct = DB("SELECT * FROM `".$Config['struct']."` WHERE `active`=1 AND `delete`=0");
    }
?>