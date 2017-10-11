<?php
	// Класс для отправки данных на e-mail
	include_once(dirname(__FILE__).'/../../'.$_CMS_ENTER.'/framework/class.phpmailer.php');

	// Проверка на ошибки
	$error = '{"err":"0","msg":"<span class=\"green\">Сообщение отправлено, мы свяжемся с Вами</span>","clear":"0"}';

	// Проверка данных
	saveVal($_POST, array('name', 'phone','email', 'message'), array('STRING_ADDSL', 'STRING_ADDSL', 'STRING_ADDSL', 'STRING_ADDSL'), '_');
	
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
				  <head><title>Новое сообщение от пользователя '.$_name.'</title><meta http-equiv="Content-Type" content="text/html; charset=utf-8" ></head>
				  <body>
					<table cellpadding="0" cellspacing="0" width="800" style="border-collapse:collapse;">
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
	if(trim($_message) != ''){
		$message_body .= '<tr><td><span style="font: bold 13px/normal Arial; color: #616161;">Текст сообщения:</span></td></tr>
						<tr><td><span style="font: italic 14px/normal Arial; color: #010101;">'.$_message.'</span></td></tr>
						<tr><td style="height:10px;"><div style="height:10px;">&nbsp;</div></td></tr>';
	}
	$message_body .= '<tr><td style="height:1px;"><hr align="left" color="#dddddd" width="100%" size="1px" /></td></tr>
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
	$subject = 'Новое сообщение от пользователя '.$_name;
	$mail = new PHPMailer();
	$mail->CharSet = 'UTF-8';
	$mail->From = 'noreply@fpro.by';
	$mail->FromName = $_name;
	$mail->AddAddress($to, '');
	$mail->IsHTML(true);
	$mail->Subject = $subject;
	$mail->Body = $message_body;
	if(!$mail->Send()) {
		$error = '{"err":"1","msg":"<span class=\"red\">Сообщение не отправлено, почтовый сервер не доступен</span>","clear":"0"}';
	}
	
	echo $error;
?>
