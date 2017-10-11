<?php
    // Сохранение переменных

    define('_POST_', $_SERVER['REQUEST_METHOD'] == 'POST' ? true : false);
    define('_GET_',  $_SERVER['REQUEST_METHOD'] == 'GET' ? true : false);

    function OutModel($Val, $Model)
    {
    	switch ($Model) {
    		case 'STRING': case 'STRING_ADDSL': case 'STRING_STRIPSL': case 'STRING_ADDCSL': case 'STRING_STRIPCSL':
    			case 'EMAIL': case 'HTML': case 'HTMLDEC': case 'HTML_ENT': case 'HTML_ENTDEC':
    			if (ini_get('magic_quotes_gpc')) $Val = stripslashes($Val);
    		break;
    	}
    	switch ($Model) {
    		case 'EMPTY': // сохраняет как пустую переменную
    			if (empty($Val)) $Out = $Val;
    			else $Out = null;
    		break;
    		case 'INT': // сохраняет как целое число
    			if ((string)(int)$Val == $Val) $Out = (int)$Val;
    			else $Out = '';
    		break;
    		case 'FLOAT': // сохраняет как дробное число
    			if ((string)(float)$Val == $Val) $Out = (float)$Val;
    			else $Out = '';
    		break;
    		case 'STRING': // сохраняет как строку (! полное копирование переменной - опасно для SQL запросов)
    			$Out = mysql_real_escape_string(trim($Val));
    		break;
    		case 'STRING_ADDSL': // сохраняет как строку с экранированными спецсимволами
    			$Out = mysql_real_escape_string(addslashes(trim($Val)));
    		break;
    		case 'STRING_STRIPSL': // сохраняет как строку с РАЗэкранированными спецсимволами
    			$Out = mysql_real_escape_string(stripslashes(trim($Val)));
    		break;
    		case 'STRING_ADDCSL': // сохраняет как строку с экранированными спецсимволами стиля языка С
    			$Out = mysql_real_escape_string(addcslashes(trim($Val)));
    		break;
    		case 'STRING_STRIPCSL': // сохраняет как строку с РАЗэкранированными спецсимволами стиля языка С
    			$Out = mysql_real_escape_string(stripcslashes(trim($Val)));
    		break;
    		case 'HTML': // сохраняет как строку с html сущностями
    			$Out = mysql_real_escape_string(htmlspecialchars(trim($Val)));
    		break;
    		case 'HTMLDEC': // сохраняет как строку с обратно преобразованными html сущностями (обратная HTML)
    			$Out = mysql_real_escape_string(htmlspecialchars_decode(trim($Val)));
    		break;
    		case 'HTML_ENT': // сохраняет как строку с html сущностями
    			$Out = mysql_real_escape_string(htmlentities(trim($Val)));
    		break;
    		case 'HTML_ENTDEC': // сохраняет как строку с обратно преобразованными html сущностями (обратная HTML)
    			$Out = mysql_real_escape_string(html_entity_decode(trim($Val)));
    		break;
    		case 'EMAIL': // сохраняет как email
    			if (!preg_match('|[a-zA-Z_0-9]+@[a-zA-Z_0-9]+(\.[a-zA-Z_0-9])*|', mysql_real_escape_string(trim($Val)))) $Out = null;
    			else $Out = $Val;
    		break;
    	}
    	return $Out;
    }

    function CycleVal($Val, $Model)
    {
    	if (is_array($Model))
    	{
    		if (!is_array($Val)) return null;
    		$Out = array();
    		foreach ($Model as $MKey => $MVal)
    		{
    			if (isset($Val[$MKey]))
    			{
    				$_Ans = CycleVal($Val[$MKey], $MVal);
    				if (!is_null($_Ans)) $Out[$MKey] = $_Ans;
    			}
    		}
    	}
    	else
    	{
    		if (is_array($Val))
    		{
    			$_keys = array_keys($Val);
    			$Model = array_fill_keys($_keys, $Model);
    			$Out = CycleVal($Val, $Model);
    		}
    		else $Out = OutModel($Val, $Model);
    	}
    	return $Out;
    }

    function SaveVal(&$Val, $What, $By, $Prefix = '', $Destination = null) // Сохранение переменной из ГЕТА или ПОСТА. Прим. SaveValue($_POST, array('variable'), array('STRING'), '_') - после выполнения переменная $_POST['variable'] доступна как $_variable
    {
        $Model = array_combine($What, $By);
    	$_CheckedVal = CycleVal($Val, $Model);
    	$Out = ($_CheckedVal == $Val) ? true : false;
    	if ((!is_null($Prefix)) && (is_array($_CheckedVal)))
    	{
            if($Destination==null)
                foreach ($_CheckedVal as $CVKey => $CVVal) $GLOBALS[$Prefix.$CVKey] = $CVVal;
            else
                foreach ($_CheckedVal as $CVKey => $CVVal) $GLOBALS[$Destination][$Prefix.$CVKey] = $CVVal;
    	}
    	else
    	{
    		$Val = $_CheckedVal;
    	}
        return $Out;
    }
?>
