<?php
    $all_left_menus = DB("SELECT `id`, `title` FROM `".$Config['menu']."` WHERE `delete`=0");
?>