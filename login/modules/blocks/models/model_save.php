<?php
    if(isset($_POST['id']) && (int)$_POST['id'] != 0) {
        DB("UPDATE ".$Config['main_table']."
            SET `name` = '".$P['name']."',
                `content` = '".$P['content']."'
             WHERE `id` = '".$_POST['id']."'");
        $_WORKER_ID = $_POST['id'];
        $_SESSION['message'] = 'Блок '.$P['name'].' обновлен';
    }
    else {
        DB("INSERT INTO ".$Config['main_table']." (`name`, `content`, `date`)
            VALUES('".$P['name']."', '".$P['content']."', '".time()."')");
        $_WORKER_ID = mysql_insert_id();
        $_SESSION['message'] = 'Блок '.$P['name'].' добавлен';
    }
?>