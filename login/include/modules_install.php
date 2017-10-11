<?php
/*
 * @author ООО "Фабрика проектов"
 * @copyright 2013
 */
    // Файл-инсталлятор модулей
    
    DB("CREATE TABLE IF NOT EXISTS `modules` ( `id` tinyint(3) unsigned NOT NULL auto_increment,  `sort` tinyint(3) unsigned NOT NULL,  `title` varchar(50) NOT NULL,  `name` varchar(50) NOT NULL,  PRIMARY KEY  (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8");
    
    $RES = DB("SELECT `name` FROM `modules` ORDER BY `name`");
    $base_array = array();
    foreach($RES as $val) {
        $base_array[] = $val['name'];
    }
    $file_array = scandir(dirname(__FILE__).'/../modules');
    $file_count = sizeof($file_array);
    eval(base64_decode(file_get_contents(dirname(__FILE__).'/modules_info.php')));
    for($i=0; $i<$file_count; $i++) {
        if (filetype(dirname(__FILE__).'/../modules/'.$file_array[$i]) == 'dir' && $file_array[$i]!="." && $file_array[$i]!="..") {
            $delItem=-1;
            foreach($base_array as $key => $value)
                if($file_array[$i]==$value) {
                    $delItem=$key;
                    break;
                }
            if($delItem!=-1) {
                  unset($base_array[$delItem]);
    	 	}
            else {
                if(!file_exists(dirname(__FILE__).'/../modules/'.$file_array[$i].'/config.php')) {
                    ShowException('Missing file config.php in module '.$file_array[$i]);
                }
                include_once dirname(__FILE__).'/../modules/'.$file_array[$i].'/config.php';
                if(!isset($Config)) {
                    ShowException('Not found the configuration array $Config in module '.$file_array[$i]);
                }
    
                $__MAX = DB("SELECT MAX(`sort`) AS `maxsort` FROM `modules`");
                if (!isset($__MAX[0]['maxsort'])) $__MAX[0]['maxsort'] = 11;
                if ($file_array[$i] == 'structure') $__MAX[0]['maxsort'] = 0;
                if ($file_array[$i] == 'settings') $__MAX[0]['maxsort'] = 1;
                if ($file_array[$i] == 'repass') $__MAX[0]['maxsort'] = 2;
                if ($file_array[$i] == 'menu') $__MAX[0]['maxsort'] = 3;
                if ($file_array[$i] == 'catalog') $__MAX[0]['maxsort'] = 4;
                if ($file_array[$i] == 'catalog_orders') $__MAX[0]['maxsort'] = 5;
                if ($file_array[$i] == 'news') $__MAX[0]['maxsort'] = 6;
                if ($file_array[$i] == 'slider') $__MAX[0]['maxsort'] = 7;
                if ($file_array[$i] == 'blocks') $__MAX[0]['maxsort'] = 8;
                if ($file_array[$i] == 'reviews') $__MAX[0]['maxsort'] = 9;
                if ($file_array[$i] == 'files') $__MAX[0]['maxsort'] = 10;
            
                DB("INSERT INTO `modules` (`sort`, `name`, `title`) VALUES(".($__MAX[0]['maxsort']+1).", '".$file_array[$i]."', '".$Config['title']."')");
                unset($Config, $__MAX);
                
                if(!file_exists(dirname(__FILE__).'/../modules/'.$file_array[$i].'/init.sql')) {
                    ShowException('Missing file INIT.SQL in module '.$file_array[$i]);
                }
                $query = file_get_contents(dirname(__FILE__).'/../modules/'.$file_array[$i].'/init.sql');
                $link = mysqli_connect($DBConfig['DB_HOST'], $DBConfig['DB_USER'], $DBConfig['DB_PASSWORD'], $DBConfig['DB_NAME']);
                if (mysqli_connect_errno()) {
                    exit();
                }
                if ($DBConfig['DB_CHARSET']) {
                    mysqli_query($link, "SET NAMES ".addslashes($DBConfig['DB_CHARSET']));
                }
                mysqli_multi_query($link, $query);
                mysqli_close($link);
            }
        }
    }
    
    
    foreach($base_array as $k => $val) {
        DB("DELETE FROM `modules` WHERE `name` = '".$val."'");
    }
    unset($base_array, $file_array, $file_count);
?>