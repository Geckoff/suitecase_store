<?php
/*
 * @author ООО "Фабрика проектов"
 * @copyright 2013
 */
    function get($_object) {
        $items = explode('_',$_object);
        if(file_exists(dirname(__FILE__).'/../modules/'.$_GET['module'].'/'.$items[0].'s/'.$_object.'.php')) {
            return dirname(__FILE__).'/../modules/'.$_GET['module'].'/'.$items[0].'s/'.$_object.'.php';
        }
        else {
            ShowException('Can not load the '.$_object, 'Controller MVC');
        }
    }

    function parse_controller($DO,$action) {
        if(isset($DO[$action])) {
            return $DO[$action];
        }
        else {
            return false;
        }
    }

    function exec_controller(&$G,&$P,$Controller) {
        if(!is_array($Controller[0]) || !is_array($Controller[1]) || $Controller[2]=='') {
            return false;
        }
        if(sizeof($Controller[0])>0) {
            SaveVal($_GET, array_keys($Controller[0]), array_values($Controller[0]), '', 'G');
        }
        if(sizeof($Controller[1])>0) {
            SaveVal($_POST, array_keys($Controller[1]), array_values($Controller[1]), '', 'P');
        }
        if(sizeof($Controller[0])!=sizeof($G)) {
            ShowException('Wrong number of parameters in an array of GET');
        }
        if(sizeof($Controller[1])!=sizeof($P)) {
            ShowException('Wrong number of parameters in an array of POST');
        }
        return $Controller[2];
    }
?>
