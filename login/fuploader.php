<?php
/*
 * @author ООО "Фабрика проектов"
 * @copyright 2013
 */
    include_once dirname(__FILE__).'/../config/admin_start.php';
    include_once 'framework/file_uploader.php';
    global $AdminConfig;
    $uploader = new qqFileUploader($AdminConfig['ALLOWED'], $AdminConfig['SIZELIMIT']);
    $result = $uploader->handleUpload('../data/temp/');
    echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
?>