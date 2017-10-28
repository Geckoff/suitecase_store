<?php
	$OUTPUT['date'] = str_replace(array('January','February','March','April','May','June','July','August','September','October','November','December'),
									  array('Января','Февраля','Марта','Апреля','Мая','Июня','Июля','Августа','Сентября','Октября','Ноября','Декабря'),
									  date('j F Y г.', $OUTPUT['date']));
?>
<div class="page-title">
	<h1><?=$TITLE?></h1>
</div>
<?php if ($TITLE == 'Акция! Интернет-магазин рюкзаков, сумок, чемоданов 1bags дарит подарки каждому покупателю!') : ?>
	<script type="text/javascript">
$(document).ready(function(){
		$("head").append("<meta property='og:url' content='https://1bags.by/discounts/akciya-1bags-darit-podarki-kazhdomu-pokupatelyu' /> ");
        $("head").append("<meta property='og:title' content=' Интернет-магазин рюкзаков, сумок, чемоданов 1bags.by дарит подарок каждому покупателю!' /> ");
        $("head").append("<meta property='og:image' content='https://1bags.by/images/oblozhka-inside.jpg' /> ");
        $("head").append("<meta property='og:description' content='1bags.by - это стильные и надежные чемоданы, рюкзаки, кошельки, спортивные, мужские и дорожные сумки. Каждый наш клиент получает бесплатный подарок! Не верите? Заходите и проверяйте!' />");
});
</script>
<?php endif; ?>
<div class="page-content">
	<p class="posted"><!--<?=$OUTPUT['date']?>--></p><?=$OUTPUT['description']?>
    <script type="text/javascript">(function() {
  if (window.pluso)if (typeof window.pluso.start == "function") return;
  if (window.ifpluso==undefined) { window.ifpluso = 1;
    var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
    s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true;
    s.src = ('https:' == window.location.protocol ? 'https' : 'http')  + '://share.pluso.ru/pluso-like.js';
    var h=d[g]('body')[0];
    h.appendChild(s);
  }})();</script>
  <div class="pluso" data-background="transparent" data-options="small,square,line,horizontal,counter,theme=04" data-services="vkontakte,odnoklassniki,facebook,twitter,google" data-user="833759409"></div>
</div>

