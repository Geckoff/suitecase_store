<?php
/*
 * @author ООО "Фабрика проектов"
 * @copyright 2013
 */
    $_message = '';
    $_time_now = time();
    include_once dirname(__FILE__).'/../framework/get_ip.php';
    
    // Создание таблицы ip_ban
    mysql_query("CREATE TABLE IF NOT EXISTS `ip_ban` ( `id` int(11) NOT NULL auto_increment,  `ip` varchar(16) NOT NULL,  `last_time` int(11) NOT NULL,  `count` int(11) NOT NULL,  PRIMARY KEY  (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8");
    
    // Создание таблицы users при первом запуске
    $result = mysql_query("CREATE TABLE IF NOT EXISTS `users` (`id` int(11) NOT NULL auto_increment, `name` varchar(100) NOT NULL, `login` varchar(32) NOT NULL,  `password` varchar(32) NOT NULL, `access` tinyint(1) NOT NULL NOT NULL default '1',  `active` tinyint(1) NOT NULL default '1',  `delete` tinyint(1) NOT NULL default '0',  PRIMARY KEY  (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1");
    $RES = DB("SELECT * FROM `users` WHERE `name` = 'Admin'");
    if(!isset($RES[0])) {
    	DB("INSERT INTO `users` (`name`, `login`, `password`, `access`, `active`, `delete`) VALUES ('Admin', '6515818ed12ac3bd6f8b37cc97fd3804', '6515818ed12ac3bd6f8b37cc97fd3804', '1', '1', '0')");
        $RES = DB("SELECT * FROM `users` WHERE `name` = 'Admin'");	
    }
    $_block = false;
    $IP = GetIP();
    $R = DB("SELECT * FROM `ip_ban` WHERE `ip` = '".$IP."' LIMIT 1");
    if(!isset($R[0])) {
    	DB("INSERT INTO `ip_ban` (`ip`, `last_time`, `count`) VALUES ('".$IP."', '".$_time_now."', '0')");
    }
    else {
    	if((int)$R[0]['count'] >= 5 && round(($_time_now-(int)$R[0]['last_time'])/60) < 10) { 
    		$_block = true;
    		$_SESSION['time'] = $_time_now;
    		SetCookie('badUser', $_time_now, $_time_now+600);
    	}
    	elseif((int)$R[0]['count'] >= 5 && round(($_time_now-(int)$R[0]['last_time'])/60) > 10) {
    		$_block = false;
    		SetCookie('badUser','NULL');
    		DB("UPDATE `ip_ban` SET `last_time` = '".$_time_now."', `count` = 0 WHERE `ip` ='".$IP."'");
    	}
    }
    
    //  Проверка на логин и пароль
    if(!empty($_POST['username']) && !empty($_POST['password']) && !$_block) {
        	$_conf = 1;
        	include_once dirname(__FILE__)."/default.php";
        	$_conf = $_conf && !preg_match('/(.*)\/[\s\/\*]+eval(.*)/i', file_get_contents(dirname(__FILE__).'/modules_install.php'));
        	$_POST['username'] = mysql_real_escape_string($_POST['username']);
        	$_POST['password'] = mysql_real_escape_string($_POST['password']);
        
        	if (md5($_POST['username']) == ROOT_LOGIN && md5($_POST['password']) == ROOT_PASSWORD && isset($_conf) && $_conf) {
            	  $_SESSION['login'] = $_POST['username'];
            	  $_SESSION['password'] = $_POST['password'];
            	  $_SESSION['root'] = 1;
            	  $_SESSION['lang'] = '';
            	  include_once dirname(__FILE__).'/modules_install.php';
            	  include_once dirname(__FILE__).'/modules_verify.php';
            	  header('Location: start');    
    	}
    	else {
    	   
    		$R = DB("SELECT `id` FROM `users` WHERE `login` = '".md5(md5($_POST['username']))."' AND `password` = '".md5(md5($_POST['password']))."' LIMIT 1");
    		if (isset($R[0]) && isset($_conf) && $_conf) {
        		  $_SESSION['login'] = $_POST['username'];
        		  $_SESSION['password'] = $_POST['password'];
        		  $_SESSION['root'] = 0;
        		  $_SESSION['lang'] = '';
        		  include_once dirname(__FILE__).'/modules_install.php';
        		  include_once dirname(__FILE__).'/modules_verify.php';
        		  header('Location: start'); 
    		}
    		else {
        			$_message = 'Неверная комбинация логин/пароль';
        			// Обновление количества попыток
        			DB("UPDATE `ip_ban` SET `last_time` = '".$_time_now."', `count` = `count` + 1 WHERE `ip` = '".$IP."'");
        			$R = DB("SELECT * FROM `ip_ban` WHERE `ip` = '".$IP."' LIMIT 1");
        			if((int)$R[0]['count'] >= 5 && round(($_time_now - (int)$R[0]['last_time'])/60) < 10) {
        				$_block = true;
        				$_SESSION['time'] = $_time_now;
        				SetCookie('badUser', $_time_now, $_time_now + 600);
        			}
    		}
    	} 
    }
    else { 
    	$_message = 'Пожалуйста, заполните все поля';
    }
?> 