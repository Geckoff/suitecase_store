<?php
    /**
       Изменяет размер изображения. $new_width и $new_height могут быть NULL
     * @param <string> $source_path
     * @param <string> $destination_path
     * @param <int|NULL> $new_width
     * @param <int|NULL> $new_height
	 * @param <string> $fit <'inside','outside','fill'>
	 * @param <string> $scale <'down','up','any'>
     */
    
    include_once 'image_resize/WideImage.php'; //libka imagresize
    function image_resize($source_path, $destination_path, $new_width, $new_height, $fit = 'inside', $scale = 'any') 
    {
        WideImage::load($source_path)->resize($new_width, $new_height, $fit, $scale)->saveToFile($destination_path);
    }
?>