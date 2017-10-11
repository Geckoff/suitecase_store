<script>
$(document).ready(function(){
	var select = '<?php if(isset($G['select']) && !empty($G['select'])) echo $G['select']; else echo 'all' ?>';
	$('#'+select).attr('src','img/radiobutton_active.png');
});
</script>
<link href="css/catalog.css" rel="stylesheet" type="text/css" />
<table cellspacing="0" cellpadding="0" width="100%">
	<tr class="tree_row">
		<td style="padding-left: 15px;">
			<div class="icon"><a href="module=catalog_orders&action=orders_show&select=all&page=1"><img id="all" src="img/radiobutton.png"></a></div>
			<div class="text"><a href="module=catalog_orders&action=orders_show&select=all&page=1">Все заказы</a></div>
		</td>
	</tr>
	<tr class="tree_row">
		<td style="padding-left: 15px;">
			<div class="icon"><a href="module=catalog_orders&action=orders_show&select=new&page=1"><img id="new" src="img/radiobutton.png"></a></div>
			<div class="text"><a href="module=catalog_orders&action=orders_show&select=new&page=1">Новые</a></div>
		</td>
	</tr>
	<tr class="tree_row">
		<td style="padding-left: 15px;">
			<div class="icon"><a href="module=catalog_orders&action=orders_show&select=unfinished&page=1"><img id="unfinished" src="img/radiobutton.png"></a></div>
			<div class="text"><a href="module=catalog_orders&action=orders_show&select=unfinished&page=1">Необработанные</a></div>
		</td>
	</tr>
	<tr class="tree_row">
		<td style="padding-left: 15px;">
			<div class="icon"><a href="module=catalog_orders&action=orders_show&select=executed&page=1"><img id="executed" src="img/radiobutton.png"></a></div>
			<div class="text"><a href="module=catalog_orders&action=orders_show&select=executed&page=1">Выполненные</a></div>
		</td>
	</tr>
	<tr class="tree_row">
		<td style="padding-left: 15px;">
			<div class="icon"><a href="module=catalog_orders&action=orders_show&select=cancelled&page=1"><img id="cancelled" src="img/radiobutton.png"></a></div>
			<div class="text"><a href="module=catalog_orders&action=orders_show&select=cancelled&page=1">Отмененные</a></div>
		</td>
	</tr>
</table>
