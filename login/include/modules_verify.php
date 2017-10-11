<?php
/*
 * @author ООО "Фабрика проектов"
 * @copyright 2013
 */

    $path2data = dirname(__FILE__).'/../../data'; // path to the data folder
    
    if (!is_dir($path2data)) { // checking existence the data folder
        if (!mkdir($path2data, 0777)) { // create the data folder with chmod 777 if does not exist
            ShowException('Error while creating folder "data"'); // if we have a problem with create folder push exeption message
        }
    } else {
        if (!chmod($path2data, 0777)){ // hange chmod for the data folder
            //ShowException('Error while changing permissions for the folder "data"');
        }
    }
    // Get module's names from database
    $modules_name = DB("SELECT `name` FROM `modules`");
    
    foreach ($modules_name as $modul){
        // below cheking existence module's subdirectory
        $path2subdir = $path2data.'/'.$modul['name']; // path to the module's subdirectory
        if (!is_dir($path2subdir)){
            if (!mkdir($path2subdir,0777)){
                ShowException('Error when creating a subdirectory in folder "data" for module "'.$value['name'].'"');
            }
        } else {
            if (!chmod($path2subdir,0777)){ //change chmod for module's subdirectory
                //ShowException('Error when changing permissions for a subdirectory in folder "data" for module "'.$value['name'].'"');
            }
        }
        unset($Config); //delete old $config for we don't have bugs if $config in next module is not isset
        
        //Here below cheking subdirectory's internal structure
        include ( dirname(__FILE__).'/../modules/'.$modul['name'].'/config.php' );
        if (!isset($Config)){
            ShowException('The configuration array "$Config" in the module "'.$modul['name'].'" not found');
        } elseif ((!isset($Config['data'])) || (!is_array($Config['data']))){
                    ShowException('The configuration subarray "data" in module "'.$modul['name'].'" not found');
               } else {
                    foreach ( $Config['data'] as $subsubdir){
                        $path2subsubdir = $path2subdir.'/'.$subsubdir;
                        if (!is_dir($path2subsubdir)){
                            if (!mkdir($path2subsubdir,0777)){
                                ShowException('Error while creating the folder "'.$path2subsubdir.'" in the modul "'.$modul['name'].'"');
                            }
                        } else {
                            if (!chmod($path2subsubdir,0777)){
                                //ShowException('Error while changing permissions for folder "'.$path2subsubdir.'" in the module "'.$modul['name'].'"');
                            }
                        }
                    }
                 }
    }
    unset ($modules_name, $Config);
?>