<?php
// Соединение с базой данных

if (!function_exists('ShowException')) {
    include_once dirname(__FILE__).'/exception.php';  
}

if (!isset($DBConfig)) {
    ShowException('Can not select config');
    exit();
}

$_ConnectionID = mysql_connect($DBConfig['DB_HOST'].':'.$DBConfig['DB_PORT'], $DBConfig['DB_USER'], $DBConfig['DB_PASSWORD']);
if ($_ConnectionID) {
	if ($DBConfig['DB_CHARSET']) mysql_query("SET NAMES ".addslashes($DBConfig['DB_CHARSET']));
	if (!mysql_select_db($DBConfig['DB_NAME'])) {
        ShowException("Can not select the database");
        exit();
    }
} else {
    ShowException("Can not connect to server");
    exit();
}

function DBResult(&$_Result_id) // Возвращение результата запроса
{
	$_Res = false;
	if ($_Result_id and ($_Result_id !== true))
	{
		$_Res = array();
		while ($_Row = mysql_fetch_assoc($_Result_id))
		{
			$_Res[] = $_Row;
		}
	}
	elseif ($_Result_id === true){
		$_Res = true;
	} else {
		return null;
	}
	return $_Res;
}

function DB($Query, $Print = 0, &$Count_row = NULL) // Обычный запрос в базу данных с возвращением результата запроса
{
	$_result = false;
    if($Print)
        echo $Query,'<br>';
	$_result_id = mysql_query($Query);
    if(! is_null($Count_row))
        $Count_row = mysql_num_rows ($_result_id);
	$_result = DBResult($_result_id);   
	return $_result;
}
?>
