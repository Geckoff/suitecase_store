<?php
/*
 * @author ООО "Фабрика проектов"
 * @copyright 2013
 */
    session_start();
	include dirname(__FILE__).'/config/client_start.php';
    include dirname(__FILE__).'/client/functions.php';
    if (isset($_POST['processor']) && !empty($_POST['processor'])){
        switch ($_POST['processor']){
            case "feedback":
                include_once dirname(__FILE__).'/client/ajax/feedback.php'; // Отправка сообщения с сайта
                break;
            case "order":
                include_once dirname(__FILE__).'/client/ajax/order.php';
                break;
            default: echo 'Ошибка в корне AJAX! Пожалуйста, попробуйте ещё раз или свяжитесь с администрацией ресурса.';
        }
    }
?>
