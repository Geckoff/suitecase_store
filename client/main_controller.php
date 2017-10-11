<?php
/*
 * @author ООО "Фабрика проектов"
 * @copyright 2013
 */
    session_start();
    include_once dirname(__FILE__)."/../config/client_start.php";
    include dirname(__FILE__)."/functions.php";
    deleteEndSlash();  // Удаление конечного слэша 
    date_default_timezone_set($ClientConfig['TIMEZONE']);

    $TEMPLATE = '';    // Шаблон страницы
    $CONTENT = '';     // Содержимое страницы
    $TEXT = '';        // Текст на странице
    $TITLE = '';       // Заголовок страницы
    $error404 = false; // Ошибка 404
     
    $PAGE = array();   /* [page] => Array ( [id] => "ID страницы" [name] => "URL/ИМЯ страницы" [[index] => "Номер страницы в URL связанной с модулем"]) 
                          [module] => Array ( [id_module] => "ID связанного со страницей модуля" [id_main_field] => "ID корневого раздела модуля" [name] => "Имя модуля" ) */  
                                             
    /* ----------------------------------------------------------------------------- */

	// Определяем страницы и модули
	$include_module_controller = false;
	
    if ((!isset($_GET['pages'])) || empty($_GET['pages'])){
    	$S = getStructByID($ClientConfig['page_main'], '`name`');
		$PAGE = getCurrentPage(array('0' => $S[0]['name']));
    }else {
    	if (isset($_GET['pages'])){
    	    $_GET['pages'] = mysql_real_escape_string($_GET['pages']);   
    		$S = explode('/', htmlspecialchars($_GET['pages']));
            $PAGE = getCurrentPage($S);
    	}
    }
	if(isset($PAGE['module']['name']) && !empty($PAGE['module']['name'])){
		$MODULE_URL = array();
		for ($i = $PAGE['page']['index'] + 1, $cnt = count($S); $i < $cnt; ++$i) {
			$MODULE_URL[] = $S[$i];
		}
		$include_module_controller = true;
	}
	 
    // Определяем текущую информацию на странице
    if (isset($PAGE['page']) && !empty($PAGE['page'])) {
    	$S = getStructByID($PAGE['page']['id']);
    	if (isset($S[0])) {
    		$TITLE = $S[0]['title'];
    		$TEXT = $S[0]['text'];
    		$META = array('meta_title' => $S[0]['meta_title'], 'meta_keywords' => $S[0]['meta_keywords'], 'meta_description' => $S[0]['meta_description']); 	 	 	
    	}
    	else {
    	    $error404 = true;   
    	}
    }else {
        $error404 = true;
    }
    unset($S);
     
    // Определяем шаблон страницы 
    if (empty($TEMPLATE)) {
        if(!$error404) {
            switch ($PAGE['page']['id']){
				case $ClientConfig['page_main']:
                    $TEMPLATE = 'main.php';
                    break;
				case $ClientConfig['page_contacts']:
                    $TEMPLATE = 'contacts.php';
                    break;
               case $ClientConfig['page_cart']:
                    $TEMPLATE = 'cart.php';
                    break;
               case $ClientConfig['page_reviews']:
                    $TEMPLATE = 'reviews.php';
                    break;
                default:
					$TEMPLATE = 'simple.php';
            }  
        }
        else {
            $TEMPLATE = 'simple.php';    
        }
    }
        
    // Подключаем основную модель для всего сайта
    include_once dirname(__FILE__)."/models/main.php";
    
	// Подключаем модель текущей страницы
    if($include_module_controller && file_exists(dirname(__FILE__)."/models/".$PAGE['module']['name'].".php")){
		include_once dirname(__FILE__)."/models/".$PAGE['module']['name'].".php";
	} else if(isset($_GET['npage'])){
			$error404 = true;
	}
	
    // Ошибка 404 
    if ($error404) {
        $TITLE = $ClientConfig['404_TITLE'];    
        $TEXT = $ClientConfig['404_TEXT'];
        $META = array('meta_title' => $ClientConfig['404_META_TITLE'], 'meta_keywords' => $ClientConfig['404_META_TITLE'], 'meta_description' => $ClientConfig['404_META_TITLE']);   
        $TEMPLATE = 'simple.php';       
        header("HTTP/1.0 404 Not Found");
    }
    
	// Подключаем выбранный шаблон
    ob_start();
    if (!empty($TEMPLATE) && file_exists(dirname(__FILE__)."/views/template/".$TEMPLATE)) {
    	include dirname(__FILE__)."/views/template/".$TEMPLATE;
    }
    $CONTENT.=ob_get_contents();
    ob_end_clean();

	include_once dirname(__FILE__)."/views/head.php";
	include_once dirname(__FILE__)."/views/content.php";
?>
