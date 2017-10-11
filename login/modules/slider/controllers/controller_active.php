<?php
    DB("UPDATE ".$Config['slider']." SET active = not(active) WHERE id=".$G['id']);
    ob_start();
    $_SESSION['info'] = 'Активность слайдера изменена';
    include get('view_right_content_slider');
    $_right_content = ob_get_contents();
    ob_end_clean();
?>