<?php
	if(!isset($_COOKIE['cart'])){
		$_class = 'hidden';
	}else {
		$cart = json_decode($_COOKIE['cart'], true);
		if(empty($cart)){
			$_class = 'hidden';
		}else{
			$_class = '';
		}
	}
?>

<div class="page-title">
	<h1><?=$TITLE?></h1>
</div>
<div class="page-content">
	<?=$TEXT?>
	<p>В корзине: <strong class="totalCntContainer"></strong></p>
	<table class="cartContainer"><tbody></tbody></table>
	<p>Всего: <strong class="totalPriceContainer"></strong></p>
</div>
<form class="smform clearfix <?=$_class?>" action="" method=""><a name="order"></a>
	<div class="legend">Оформление заказа</div>
	<fieldset>
		<label class="verify">Ваше ФИО <span class="red">*</span><br />
			<input type="text" name="name" value="" onclick="yaCounter24243322.reachGoal('name'); return true;"/>
			<span class="error">Введите Ваше ФИО</span>
		</label>
		<label class="verify">Ваш телефон <span class="red">*</span><br />
			<input type="text" name="phone" value="" onclick="yaCounter24243322.reachGoal('phone'); return true;" />
			<span class="error">Номер телефона не указан или введен не корректно</span>
		</label>
		<label>Ваш e-mail<br/>
			<input type="text" name="email" value="" />
		</label>
		<label>Адрес доставки<br/>
			<input type="text" name="address" value="" />
		</label>
		<label>Примечание<br />
			<textarea name="message"></textarea>
		</label>
		<small>Поля обозначенные <span class="red">*</span> обязательны для заполнения</small><br />
		<button class="btn btn-red send" name="send" value="send" data-handler="order" onclick="yaCounter24243322.reachGoal('bought'); return true;">Оформить заказ</button>
	</fieldset>
</form>
