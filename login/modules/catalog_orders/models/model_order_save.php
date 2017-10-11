<?php
DB("update `".$Config['catalog_orders']."` set `state` = '".$P['state']."' where `id` = '".$G['id']."' limit 1");
?>
