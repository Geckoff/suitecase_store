<?php
    // Глобальные настройки CMS

    // PRECONFIG ---------------------------------------------
    $_ROOT = dirname(__FILE__).'/..';
    $_VER = '4.1';
    $_VER_STABILITY = 'stable';
    $_CMS_ENTER = 'login';

    // ADMIN CONFIG ------------------------------------------
    $AdminConfig = array(
        'ROOT' => $_ROOT,
    	'HOST' => 'http://'.$_SERVER['HTTP_HOST'],

    	'DATA_URL' => 'http://'.$_SERVER['HTTP_HOST'].'/data',
    	'DATA_ROOT' => $_ROOT.'/data',
    	'ADMIN_ROOT' => $_ROOT.'/'.$_CMS_ENTER,
    	'MODULES_ROOT' => $_ROOT.'/'.$_CMS_ENTER.'/modules',

    	'DEBUG' => true,
    	'PROFILER' => false,

    	'CMS_VER' => $_VER,
    	'CMS_VER_STABILITY' => $_VER_STABILITY,
    	'CMS_VER_LOGO' => 'Factory Project CMS v'.$_VER.' '.$_VER_STABILITY,

        'TIMEZONE' => 'Europe/Minsk',
        'SIZELIMIT' => 64 * 1024 * 1024,
        'ALLOWED' => array('doc','docx','ppt','pptx','xls','xlsx','mdb','accdb','swf','flv','mp4','avi','mpg','zip','rar','7z','rtf','pdf','psd','mp3','wma','txt','jpeg','jpg','gif','png','JPEG','JPG','GIF','PNG'),
    );
    unset($_ROOT, $_VER, $_VER_STABILITY);
?>