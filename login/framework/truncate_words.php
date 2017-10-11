<?php
    // Обрезать строку UTF-8 до нужного количества символов, не обрезав последнее слово
    function TruncateWords($text, $limit = 1000)
    {
    	$text=mb_substr($text,0,$limit);
    	// если не пустая обрезаем до  последнего  пробела
    	if(mb_substr($text,mb_strlen($text)-1,1) && mb_strlen($text)==$limit)
    	{
    		$textret=mb_substr($text,0,mb_strlen($text)-mb_strlen(strrchr($text,' ')));
    		if(!empty($textret))
    		{
    			return $textret;
    		}
    	}
    	return $text;
    }
?>