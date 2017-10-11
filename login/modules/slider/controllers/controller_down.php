<?php
    DB_sort('down',$G['id'],$Config['main_table'],'AND parent = (SELECT parent FROM '.$Config['main_table'].' WHERE id = '.$G['id'].')');
    ob_start();
    $_SESSION['info'] = 'Страница перемещена на уровень вниз';
    include get('view_right_content_slider');
    $_right_content = ob_get_contents();
    ob_end_clean();
?>