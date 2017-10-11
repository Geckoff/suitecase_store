<?php
    $_BLOCKS = DB("SELECT * FROM ".$Config['main_table']." WHERE `id` = '".$G['id']."' AND `delete` = 0 LIMIT 1");
?>