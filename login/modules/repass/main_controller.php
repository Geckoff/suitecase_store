<?php
    $DO = array(
        'blank' => array(array(), array(), 'controller_blank.php'),
        'delete' => array(array('id' => 'INT'), array(), 'controller_delete.php'),
        'active' => array(array('id' => 'INT'), array(), 'controller_active.php'),
        'save' => array(array(), array('login' => 'STRING_ADDSL', 'oldpass' => 'STRING_ADDSL', 'newpass' => 'STRING_ADDSL', 'newpass2' => 'STRING_ADDSL'), 'controller_save.php')
    );
?>