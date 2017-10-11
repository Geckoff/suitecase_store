<?php
    $DEL = DB("SELECT `image` FROM ".$Config['slider']." WHERE (id = ".$G['id']." OR parent = ".$G['id'].") AND `image` <> '' ");
    if(isset($DEL[0]))
        foreach ($DEL as $val)
            unlinkImage($val['image']);

    DB("UPDATE ".$Config['slider']." SET `delete`=1 WHERE `id` = ".$G['id']);
    DB("UPDATE ".$Config['slider']." SET `delete`=1 WHERE `parent` = ".$G['id']);
    $_SESSION['message'] = 'Запись успешно удалена';
    setCookie('msg','1');
    header("Location: ".$URL."&action=blank");
?>