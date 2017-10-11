<?php
    $_Pages_list = DB("SELECT * FROM ".$Config['main_table']." WHERE `delete` = 0");
?>