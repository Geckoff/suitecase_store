<?php
	// Класс для отправки данных на e-mail
	include_once(dirname(__FILE__).'/../../'.$_CMS_ENTER.'/framework/class.phpmailer.php');
    // Глобальные переменные модуля "Каталог"
	$url = getStructByID($ClientConfig['page_catalog'], '`name`'); // URL страницы "Каталог"
	$url = $ClientConfig['HOST'].'/'.$url[0]['name'];
	
	// id корневого раздела
	$root =  getRelation($ClientConfig['page_catalog']);
	
	if(!isset($_COOKIE['cart'])){
		echo '{"err":"1","msg":"<span class=\"red\">Заказ не оформлен, корзина пуста!</span>","clear":"0"}';
		exit();
	}else {
		$cart = json_decode($_COOKIE['cart'], true);
		if(empty($cart)){
			echo '{"err":"1","msg":"<span class=\"red\">Заказ не оформлен, корзина пуста!</span>","clear":"0"}';
			exit();
		}
	}
	$cart = json_decode($_COOKIE['cart'], true);
	DB("INSERT INTO `".$TABLE['catalog_orders']."` (`date`,`state`,`ip`) VALUES('".time()."','2','".GetIp()."')");
	$_last_id = (int)mysql_insert_id();
	$_summary = 0;
	$_product = '<table cellpadding="0" cellspacing="0" style="border-collapse:collapse;text-align: center;"><tbody>
						<tr>
							<td style="background: #eeeeee; width: 100px; padding: 10px; border: 1px solid #bbbbbb;">Артикул</td>
							<td style="background: #eeeeee; width: 300px; padding: 10px; border: 1px solid #bbbbbb;">Наименование</td>
							<td style="background: #eeeeee; width: 140px; padding: 10px; border: 1px solid #bbbbbb;">Цена</td>
							<td style="background: #eeeeee; width: 140px; padding: 10px; border: 1px solid #bbbbbb;">Количество</td>
							<td style="background: #eeeeee; width: 140px; padding: 10px; border: 1px solid #bbbbbb;">Стоимость</td>
						</tr>';
	for($i = 0, $cnt = count($cart); $i < $cnt; $i++){
		$tmp = $category = $tmp_cat = $tImg = '';
		$tmp = DB("SELECT `id_tree`,`title`,`url`,`ds_price` FROM `".$TABLE['catalog_item']."` WHERE `id` = '".$cart[$i]['pid']."' LIMIT 0, 1");
		if(!empty($tmp)){
			$category = getUrlTree($TABLE['catalog_tree'], $tmp[0]['id_tree'], $root);
			$category[]['url'] = $url;
			for($cntCat = count($category), $j = $cntCat -1; $j >= 0; $j--){
				$tmp_cat .= $category[$j]['url'].'/';
			}
			$_summary += $tmp[0]['ds_price'] * $cart[$i]['cnt'];
			$_product .= '<tr>
							<td style="width: 100px; padding: 10px; border: 1px solid #bbbbbb;">'.$cart[$i]['pid'].'</td>
							<td style="width: 300px; padding: 10px; border: 1px solid #bbbbbb;"><a href="'.$tmp_cat.$tmp[0]['url'].'" title="'.$tmp[0]['title'].'" target="_blank">'.$tmp[0]['title'].'</a></td>
							<td style="width: 140px; padding: 10px; border: 1px solid #bbbbbb;">'.number_format($tmp[0]['ds_price'],0,',',' ').' руб.</td>
							<td style="width: 140px; padding: 10px; border: 1px solid #bbbbbb;">'.$cart[$i]['cnt'].'</td>
							<td style="width: 140px; padding: 10px; border: 1px solid #bbbbbb;">'.number_format($tmp[0]['ds_price'] * $cart[$i]['cnt'],0,',',' ').' руб.</td>
						</tr>';
		}
	}
	$_product .= '</tbody></table>Итого: <b>'.number_format($_summary,0,',',' ').'</b> руб.';

	// Проверка на ошибки
	$error = '{"err":"0","msg":"<span class=\"green\">Спасибо за покупку! Наш менеджер перезвонит Вам в ближайшее время!</span>","clear":"1"}';

	// Проверка данных
	saveVal($_POST, array('name', 'phone', 'email', 'address', 'message'), array('STRING_ADDSL', 'STRING_ADDSL', 'STRING_ADDSL', 'STRING_ADDSL', 'STRING_ADDSL'), '_');
	
	$to = '';
	
	$emailArr = DB("select `value` from `".$TABLE['settings_element']."` where `id_setting` = '2' and `delete` = '0' order by `sort` asc");
	
	// Шаблон e-mail
	for($i = 0, $cnt = count($emailArr); $i < $cnt; $i++){
		if(preg_match('/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,8}|[0-9]{1,3})(\]?)$\.?$/i', trim($emailArr[$i]['value']))){
			$to = trim($emailArr[$i]['value']);
			break;
		}
	}
	if($to == ''){
		$to = 'info@fpro.by';
	}

	$_message = preg_replace('/(\\\r\\\n)+/', '<br />', $_message);
	// Формирование тела письма
	$message_body = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
				<html>
				  <head><title>'.$_last_id.' | Новый заказ от пользователя '.$_name.'</title><meta http-equiv="Content-Type" content="text/html; charset=utf-8" ></head>
				  <body>
					<table cellpadding="0" cellspacing="0" width="820" style="border-collapse:collapse;">
						<tr><td><span style="font: bold 13px/normal Arial; color: #616161;">№ заказа:</span></td></tr>
						<tr><td><span style="font: italic 14px/normal Arial; color: #010101;">'.$_last_id.'</span></td></tr>
						<tr><td style="height:10px;"><div style="height:10px;">&nbsp;</div></td></tr>
						<tr><td><span style="font: bold 13px/normal Arial; color: #616161;">Автор:</span></td></tr>
						<tr><td><span style="font: italic 14px/normal Arial; color: #010101;">'.$_name.'</span></td></tr>
						<tr><td style="height:10px;"><div style="height:10px;">&nbsp;</div></td></tr>
						<tr><td><span style="font: bold 13px/normal Arial; color: #616161;">Телефон:</span></td></tr>
						<tr><td><span style="font: italic 14px/normal Arial; color: #010101;">'.$_phone.'</span></td></tr>
						<tr><td style="height:10px;"><div style="height:10px;">&nbsp;</div></td></tr>';
	if(trim($_email) != ''){
		$message_body .= '<tr><td><span style="font: bold 13px/normal Arial; color: #616161;">E-mail:</span></td></tr>
						<tr><td><span style="font: italic 14px/normal Arial; color: #010101;">'.$_email.'</span></td></tr>
						<tr><td style="height:10px;"><div style="height:10px;">&nbsp;</div></td></tr>';
	}
	if(trim($_address) != ''){
		$message_body .= '<tr><td><span style="font: bold 13px/normal Arial; color: #616161;">Адрес доставки:</span></td></tr>
						<tr><td><span style="font: italic 14px/normal Arial; color: #010101;">'.$_address.'</span></td></tr>
						<tr><td style="height:10px;"><div style="height:10px;">&nbsp;</div></td></tr>';
	}
	if(trim($_message) != ''){
		$message_body .= '<tr><td><span style="font: bold 13px/normal Arial; color: #616161;">Примечание:</span></td></tr>
						<tr><td><span style="font: italic 14px/normal Arial; color: #010101;">'.$_message.'</span></td></tr>
						<tr><td style="height:10px;"><div style="height:10px;">&nbsp;</div></td></tr>';
	}
	$message_body .= '<tr><td><span style="font: bold 13px/normal Arial; color: #616161;">В заказе:</span></td></tr>
						<tr><td><span style="font: italic 14px/normal Arial; color: #010101;">'.$_product.'</span></td></tr>
						<tr><td style="height:10px;"><div style="height:10px;">&nbsp;</div></td></tr>
						<tr><td style="height:1px;"><hr align="left" color="#dddddd" width="100%" size="1px" /></td></tr>
						<tr><td style="height:10px;"><div style="height:10px;">&nbsp;</div></td></tr>
						<tr>
							<td>
								<span style="font: normal 12px/normal Arial; color:#616161;">
									<b>IP автора:</b> '.GetIp().'<br />
									<b>Браузер и OC:</b> '.$_SERVER['HTTP_USER_AGENT'].'<br />
									<b>Откуда пришёл:</b> '.$_SERVER['HTTP_REFERER'].'<br />
								</span>
							</td>
						</tr>
						<tr><td style="height:20px;"><div style="height:20px;">&nbsp;</div></td></tr>
					</table>
			</body></html>';

	$subject = $_last_id.' | Новый заказ от пользователя '.$_name;
	$mail = new PHPMailer();
	$mail->CharSet = 'UTF-8';
	$mail->From = 'noreply@fpro.by';
	$mail->FromName = $_name;
	$mail->AddAddress($to, '');
	$mail->IsHTML(true);
	$mail->Subject = $subject;
	$mail->Body = $message_body;
	if(!$mail->Send()) {
		$error = '{"err":"1","msg":"<span class=\"red\">Заказ не оформлен, почтовый сервер не доступен</span>","clear":"0"}';
		DB("DELETE FROM `".$TABLE['catalog_orders']."` WHERE `id` = ".(int)$_last_id);
	}else{
		DB("UPDATE `".$TABLE['catalog_orders']."`
			SET `name` = '".$_name."',
				`phone` = '".$_phone."',
				`email` = '".$_email."',
				`address` = '".$_address."',
				`comment` = '".$_message."',
				`price` = '".$_summary."'
			WHERE `id` = ".(int)$_last_id);
		for($i = 0, $cnt = count($cart); $i < $cnt; $i++){
			DB("INSERT INTO `".$TABLE['catalog_orders_products']."` (`id_order`,`id_product`,`count`) VALUES('".$_last_id."','".$cart[$i]['pid']."','".$cart[$i]['cnt']."')");
			DB("UPDATE `".$TABLE['catalog_item']."` SET `popularity` = (`popularity` + ".(int)$cart[$i]['cnt'].") WHERE `id` = ".(int)$cart[$i]['pid']);
		}
	}
	
	echo $error;
?>
