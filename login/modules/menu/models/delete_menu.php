<?php
DB("UPDATE `".$Config['menu']."` SET `delete`=1 WHERE `id`=".$G['id']);
DB("UPDATE `".$Config['menu_elements']."` SET `delete`=1 WHERE `id_menu`=".$G['id']);
?>
