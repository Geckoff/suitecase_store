<?php
    $Config = array(
    	'title' => 'Страницы', 
    	'main_table' => 'struct', 
        'main_field' => 'title',
    	'data' => array(), 
        
    	'table_relations' => 'struct_relations',
        
    	'MODULES_ROOT' => dirname(__FILE__).'/..',
    	'MODULE_ROOT' => dirname(__FILE__),
    	'CONTROLLER_ROOT' => dirname(__FILE__).'/controllers',
    	'MODEL_ROOT' => dirname(__FILE__).'/models',
    	'VIEW_ROOT' => dirname(__FILE__).'/views'
    );
?>