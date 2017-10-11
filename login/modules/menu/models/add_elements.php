<?php
include_once dirname(__FILE__)."/get_all_right_menus_elements.php";
$i = 0;
foreach ($P['menu_name'] as $element){
    if (!isset($menu_elements[$i]['id'])){
        DB("INSERT INTO `".$Config['menu_elements']."` (`id_menu`, `title`, `chpu`, `url`, `id_page`) VALUES (".$G['id'].",'".$element."','".translit($element)."','".$P['menu_url'][$i]."','".$P['id_from_struct'][$i]."')");
    }
    else {
        if ($menu_elements[$i] != $element){
        DB("UPDATE `".$Config['menu_elements']."` SET `title`='".$element."',`chpu`='".translit($element)."' WHERE `id`='".$menu_elements[$i]['id']."'" );
        }
        if ($pages_from_struct[$i] != $P['id_from_struct'][$i]){
        DB("UPDATE `".$Config['menu_elements']."` SET `id_page`='".$P['id_from_struct'][$i]."' WHERE `id`=".$menu_elements[$i]['id']);
        }
        if ($pages_from_struct[$i] != $P['menu_url'][$i]){
        DB("UPDATE `".$Config['menu_elements']."` SET `url`='".$P['menu_url'][$i]."' WHERE `id`=".$menu_elements[$i]['id']);
        }
    }
    ++$i;
}
?>