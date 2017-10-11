<?php
    // Функция генерации случайной строки
    function RandStr($count = 10, $num = 1, $lover = 1, $upper = 0, $symbol = 0) {
        if ($num == 1) {
            $tmpNum = "1234567890";
        } 
        else {
            $tmpNum = "";
        }
        if ($lover == 1) {
            $tmpLower = "qazxswedcvfrtgbnhyujmkiolp"; 
        } 
        else {
            $tmpLower = "";
        }
        if ($upper == 1) {
            $tmpUpper = "QAZXSWEDCVFRTGBNHYUJMKIOLP";
        } 
        else {
            $tmpUpper = "";
        }
        if ($symbol == 1) {
            $tmpSymbol = ".,()!?&%@*$+-";
        }  
        else {
            $tmpSymbol = "";
        }
        $chars = $tmpNum.$tmpLower.$tmpUpper.$tmpSymbol;
        $size = StrLen($chars)-1;
        $resultPass = null;
        while ($count--) {
          $resultPass .= $chars[rand(0, $size)];
        }
        return $resultPass;
    }
?>