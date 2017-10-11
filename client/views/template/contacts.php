<div class="page-title">
	<h1><?=$TITLE?></h1>
</div>
<div class="page-content">
	<?=$TEXT?>
</div>
<form class="smform clearfix" action="" method="">
	<div class="legend">Отправьте сообщение</div>
	<fieldset>
		<label class="verify">Ваше имя <span class="red">*</span><br />
			<input type="text" name="name" value="" />
			<span class="error">Введите Ваше имя</span>
		</label>
		<label class="verify">Ваш телефон <span class="red">*</span><br />
			<input type="text" name="phone" value="" />
			<span class="error">Номер телефона не указан или введен не корректно</span>
		</label>
		<label>Ваш e-mail<br/>
			<input type="text" name="email" value="" />
		</label>
		<label class="verify">Сообщение <span class="red">*</span><br />
			<textarea name="message"></textarea>
			<span class="error">Введите текст сообщения</span>
		</label>
		<small>Поля обозначенные <span class="red">*</span> обязательны для заполнения</small><br />
		<button class="btn btn-red send" name="send" value="send" data-handler="feedback">Отправить сообщение</button>
	</fieldset>
</form>
<div class="page-content">
<?php 
    if (isset($CONTACTS_BLOCK[0])) {
            echo $CONTACTS_BLOCK[0]['content'];    
    }
?>
</div>