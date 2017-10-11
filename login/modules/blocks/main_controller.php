<?php
    $DO = array(
        'blank' => array(array(), array(), 'controller_append.php'),
        'blocks_edit' => array(array('id' => 'INT'), array(), 'controller_edit.php'),
        'blocks_delete' => array(array('id' => 'INT'), array(), 'controller_delete.php'),
        'blocks_active' => array(array('id' => 'INT'), array(), 'controller_active.php'),
        'blocks_save' => array(array(), array('name' => 'STRING', 'content' => 'STRING'), 'controller_save.php')
    );
?>