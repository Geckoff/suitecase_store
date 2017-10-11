<?php
    $DO = array(
        'blank' => array(array(), array(), 'controller_blank.php'),
        'add' => array(array('parent' => 'INT'), array(), 'controller_add.php'),
        'show' => array(array('id' => 'INT'), array(), 'controller_show.php'),
        'delete' => array(array('id' => 'INT','parent' => 'INT'), array(), 'controller_delete.php'),
        'save' => array(array(), array('id' => 'INT', 'parent' => 'INT', 'value' => 'STRING', 'title' => 'STRING'), 'controller_save.php'),
        'save_slider' => array(array(), array('id' => 'INT', 'title' => 'STRING'), 'controller_save_slider.php'),
        'up' => array(array('id' => 'INT'), array(), 'controller_up.php'),
        'down' => array(array('id' => 'INT'), array(), 'controller_down.php'),
        'active' => array(array('id' => 'INT'), array(), 'controller_active.php')
    );
?>