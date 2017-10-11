<?php
    $DO = array(
        'blank' => array(array(/*GET*/),array(/*POST*/),'blank.php'),
        'show_elements' => array(array('id' => 'INT'), array(), 'show_elements.php'),
        'add_menu' => array(array(), array('menu_name' => 'STRING'), 'add_menu.php'),
        'delete_menu' => array(array('id' => 'INT'), array(), 'delete_menu.php'),
        'add_elements' => array(array('id' => 'INT'), array('menu_name' => 'STRING', 'id_from_struct' => 'STRING_ADDSL', 'menu_url' => 'STRING_ADDSL' ), 'add_elements.php'),
        'delete_element' => array(array('id' => 'INT', 'menu_id' => 'INT'), array(), 'delete_element.php'),
        'edit_menu' => array(array(), array(), 'edit_menu.php'),
        'edit_element' => array(array(), array(), 'edit_element.php')
    );
?>