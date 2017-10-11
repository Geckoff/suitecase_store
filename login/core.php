<?php
/*
 * @author ООО "Фабрика проектов"
 * @copyright 2013
 */
    include_once dirname(__FILE__).'/../config/admin_start.php';
    include_once dirname(__FILE__).'/include/controller_mvc.php';
    include_once dirname(__FILE__).'/include/default.php';
    session_start();
	if(isset($_COOKIE['msg']) && $_COOKIE['msg']==1){
		$msg = 1;
		setCookie('msg',NULL);
	}
    if(!$AdminConfig['DEBUG']) {
        error_reporting(0);
    }
    else {
        error_reporting(E_ALL);
    }

    // turn on/off microtime begin profiler
    if($AdminConfig['PROFILER']) {
        $mtime = microtime();
        $mtime = explode(" ",$mtime);
        $mtime = $mtime[1] + $mtime[0];
        $tstart = $mtime;
    }

    // user verify
    if(!isset($_SESSION['login'])) {
        header('Location: ../'.$_CMS_ENTER);
        exit();
    }

    // logout
    if(isset($_GET['do']) && $_GET['do'] == 'logout') {
        unset($_SESSION['login'], $_SESSION['password'], $_SESSION['root'], $_SESSION['time']);
        SetCookie('badUser', 'NULL');
        $IP = GetIP();
        DB("UPDATE `ip_ban` SET `last_time` = '".$_SERVER['REQUEST_TIME']."', `count` = 0 WHERE `ip` ='".$IP."'");
        session_destroy();
        header('Location: ../'.$_CMS_ENTER);
        exit();
    }


    $_Menu = DB("SELECT * FROM `modules` ORDER BY `sort` ASC");
    $_Settings = DB("SELECT * FROM `settings` LIMIT 1");

    // begin processing
    global $URL;
    global $ACTION;
    $G = array();
    $P = array();

    SaveVal($_GET, array('module', 'action'), array('STRING_ADDSL', 'STRING_ADDSL'));

    if(!isset($module)) {
        $module = $_Menu[0]['name'];
    }
    if(!isset($action)) {
        $action = 'blank';
    }
    if($module == '' || $action == '') {
        ShowException('Parameter is not specified MODULE or ACTION');
    }
    $URL = 'module='.$module;
    $ACTION = '&action='.$action;

    // verify main_controller in the module
    if(!file_exists(dirname(__FILE__).'/modules/'.$module.'/main_controller.php')) {
        ShowException('Missing file /'.$module.'/main_controller.php');
    }
    include_once dirname(__FILE__).'/modules/'.$module.'/main_controller.php';

    // verify config in the module
    if(!file_exists(dirname(__FILE__).'/modules/'.$module.'/config.php')) {
        ShowException('Missing file /'.$module.'/config.php');
    }
    include_once dirname(__FILE__).'/modules/'.$module.'/config.php';

    // verify $DO
    if(!isset($DO) || !is_array($DO)) {
        ShowException('Not defined array $DO in the file /'.$module.'/main_controller.php');
    }

    // $DO execution
    $Main_controller = parse_controller($DO, $action);
    if(!$Main_controller) {
        ShowException('The controller does not describe the action '.$action);
    }
    if(!is_array($Main_controller)) {
        ShowException('Controller has an invalid format');
    }

    // subcontroller execution
    $Sub_controller = exec_controller($G, $P, $Main_controller);
    if(!$Sub_controller || !file_exists(dirname(__FILE__).'/modules/'.$module.'/controllers/'.$Sub_controller)) {
        ShowException('Controller '.$Sub_controller.' can not be found');
    }

    if(!$AdminConfig['DEBUG']) {
        ob_start();
    }
        if (file_exists(dirname(__FILE__).'/modules/'.$module.'/before_action.php')) {
            include_once dirname(__FILE__).'/modules/'.$module.'/before_action.php';
        }
        include_once dirname(__FILE__).'/modules/'.$module.'/controllers/'.$Sub_controller;
        if (file_exists(dirname(__FILE__).'/modules/'.$module.'/after_action.php')) {
            include_once dirname(__FILE__).'/modules/'.$module.'/after_action.php';
        }
    if(!$AdminConfig['DEBUG']) {
        ob_end_clean();
    }

    // load main view
    include_once dirname(__FILE__).'/view/main.php';

    // turn on/off microtime end profiler
    if($AdminConfig['PROFILER']) {
        $mtime = microtime();
        $mtime = explode(" ",$mtime);
        $mtime = $mtime[1] + $mtime[0];
        $tend = $mtime;
        $totaltime = ($tend - $tstart);
        print ($totaltime);
    }
?>
