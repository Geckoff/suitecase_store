<?php
    DB("UPDATE ".$Config['main_table']." SET `active` = NOT `active` WHERE id = ".$G['id']);
?>