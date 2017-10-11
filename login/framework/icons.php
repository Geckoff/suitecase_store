<?php  
    // Иконки
    function icon_draw($type, $link, $additional = '') {
        switch ($type) {
            case 'settings':
                return '<div class="settings" id="settings" '.$additional.'><a href="'.$link.'" title="Параметры"><img src="img/struct-content-settings.png" alt="߉" /></a></div>';
                break;
            case 'up':
                return '<div class="up" id="up" '.$additional.'><a href="'.$link.'" title="Вверх"><img src="img/struct-content-up.png" alt="↑" /></a></div>';
                break;
            case 'down':
                return '<div class="down" id="down" '.$additional.'><a href="'.$link.'" title="Вниз"><img src="img/struct-content-down.png" alt="↓" /></a></div>';
                break;
            case 'add':
                return '<div class="add" id="add" '.$additional.'><a href="'.$link.'" title="Добавить"><img src="img/struct-content-add.png" alt="+" /></a></div>';
                break;
            case 'edit':
                return '<div class="edit" id="edit" '.$additional.'><a href="'.$link.'" title="Редактировать"><img src="img/struct-content-edit.png" alt="+" /></a></div>';
                break;
            case 'delete':
                return '<div class="delete" id="delete" '.$additional.'><a href="'.$link.'" title="Удалить"><img src="img/struct-content-delete.png" alt="✖" onclick="return confirm(\'Вы действительно хотите удалить?\');" /></a></div>';
                break;
        }
        if ( isset($type['check']) ) {
            return '<div class="check" id="check" '.$additional.'><a href="'.$link.'" title="'.(($type['check'])? 'Деактивировать': 'Активировать').'"><img src="img/struct-content-check'.(($type['check'])? '-active': '').'.png" alt="'.$type['check'].'" onmouseover="javascript: this.src=\'img/struct-content-check-active.png\';" onmouseout="javascript: this.src=\'img/struct-content-check'.(($type['check'])? '-active': '').'.png\';" /></a></div>';
        }
    }
?>