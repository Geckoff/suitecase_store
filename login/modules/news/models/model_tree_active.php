<?php
    DB("update `".$Config['table']['tree']."` set `active` = not `active` where `id` = ".$G['id']);
?>
