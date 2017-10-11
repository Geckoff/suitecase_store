<?php
    // Cклоняем слова по-русски
    function PluralType($n) {
         $n = abs($n);
         return ($n%10==1 && $n%100!=11 ? 0 : ($n%10>=2 && $n%10<=4 && ($n%100<10 || $n%100>=20) ? 1 : 2));
    }

    // $_plural_days = array('день', 'дня', 'дней');
    // $_plural_years = array('год', 'года', 'лет');
    // $_plural_months = array('месяц', 'месяца', 'месяцев');
    // $_plural_days = array('день', 'дня', 'дней');
    // $_plural_times = array('раз', 'раза', 'раз');
    // $_plural_products = array('товар', 'товара', 'товаров');

    /*
        Пример работы:

        $var = 1;
        echo $var.' '.$_plural_years[plural_type($var)]; // 1 год

        $var = 3;
        echo $var.' '.$_plural_days[plural_type($var)]; // 3 дня

        $var = 8;
        echo $var.' '.$_plural_times[plural_type($var)]; // 8 раз

    */
?>