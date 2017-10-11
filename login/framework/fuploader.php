<?php
    $uploader = new qqFileUploader($AdminConfig['ALLOWED'], $AdminConfig['SIZELIMIT']);
    $result = $uploader->handleUpload('../../data/temp/');
    echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
?>