<?php
    //редактирование
    if(isset($_POST['id']) && $_POST['id']!='') {
        if(DB("UPDATE ".$Config['slider']." SET title='".$P['title']."' WHERE id=".$_POST['id'])) {
            $_RIGHT['message'] = 'Запись "'.$P['title'].'" успешно обновлена';
            $_last_id = (int)$_POST['id'];
            $error = 2;
        }
        else
            $_RIGHT['error'] = 'Ошибка при обновлении записи';
    }

    //вставка
    else {
        $_sort_max = DB("SELECT MAX(sort) AS sort FROM ".$Config['main_table']);
        if( DB("INSERT INTO ".$Config['slider']." (`sort`, `title`, `description`, `url`, `image`)
                                                 VALUES('".($_sort_max[0]['sort']!='' ? (int)($_sort_max[0]['sort']+1) : 1)."',
                                                        '".$P['title']."','','','')")
          ) {
			  $error = 0;
              $_RIGHT['message'] = 'Запись "'.$P['title'].'" успешно добавлена';
              $_last_id = mysql_insert_id();
            }
        else
            $_RIGHT['error'] = 'Ошибка при добавлении записи';
    }

?>
