<?php
    DB_sort('up',$G['id'],$Config['slider'],'AND parent = (SELECT parent FROM '.$Config['slider'].' WHERE id = '.$G['id'].')');
    ob_start();
    $_SESSION['info'] = 'Страница перемещена на уровень вверх';
    include get('view_right_content_slider');
    $_right_content = ob_get_contents();
    ob_end_clean();
?>