<?php
#echo "<pre>"; print_r($ORDER); echo"</pre>";
?>
<form method="post" action="module=catalog_orders&action=order_save&id=<?php echo $ORDER['id']; ?>">
<div class="block-header"><?php echo 'Заказ №'.$ORDER['id'].', поступивший '.$ORDER['date']; ?></div>
<div class="block">
	<table class="order" cellspacing="0" cellpadding="0" class="block" width="600px">
		<tbody>
			<tr style="border-bottom: 1px solid #bbb;">
				<td class="td-text td-text-head">Имя заказчика:</td>
				<td class="td-text"><?php echo $ORDER['name'];?></td>
			</tr>
			<tr style="border-bottom: 1px solid #bbb;">
				<td class="td-text td-text-head">Телефон заказчика:</td>
				<td class="td-text"><?php echo $ORDER['phone'];?></td>
			</tr>
			<tr style="border-bottom: 1px solid #bbb;">
				<td class="td-text td-text-head">E-mail заказчика:</td>
				<td class="td-text"><?php echo $ORDER['email'];?></td>
			</tr>
			<tr style="border-bottom: 1px solid #bbb;">
				<td class="td-text td-text-head">Адрес заказчика:</td>
				<td class="td-text"><?php echo $ORDER['address'];?></td>
			</tr>
			<tr style="border-bottom: 1px solid #bbb;">
				<td class="td-text td-text-head">Дата поступления заказа:</td>
				<td class="td-text"><?php echo $ORDER['date'];?></td>
			</tr>
			<tr style="border-bottom: 1px solid #bbb;">
				<td class="td-text td-text-head">Сумма товаров в заказе:</td>
				<td class="td-text"><?php echo $ORDER['price'];?></td>
			</tr>
			<tr>
				<td class="td-text td-text-head">Комментарий заказчика:</td>
				<td class="td-text td-italic">"<?php echo $ORDER['comment'];?>"</td>
			</tr>
		</tbody>
	</table>
</div>
<div class="block-header">Статус заказа</div>
<div class="block">
	<table class="order" id="state" cellspacing="0" cellpadding="0" class="block" width="600px">
		<tbody>
			<tr style="border-bottom: 1px solid #bbb;">
				<td class="td-text td-text-head">Текущий статус:</td>
				<td class="td-text td-imp-inf"><?php echo $ORDER['state-text'];?></td>
			</tr>
			<tr style="border-bottom: 1px solid #bbb;">
				<td class="td-text td-text-head">Отметить как <span>НЕОБРАБОТАННЫЙ</span>:</td>
				<td class="td-text"><input class="radio" type="radio" name="state" value="0" <?php if($ORDER['state'] == '0') echo 'checked="checked"'; else echo ''; ?> /></td>
			</tr>
			<tr style="border-bottom: 1px solid #bbb;">
				<td class="td-text td-text-head">Отметить как <span>ВЫПОЛЕННЫЙ</span>:</td>
				<td class="td-text"><input class="radio" type="radio" name="state" value="1" <?php if($ORDER['state'] == '1') echo 'checked="checked"'; else echo ''; ?> /></td>
			</tr>
			<tr style="border-bottom: 1px solid #bbb;">
				<td class="td-text td-text-head">Отметить как <span>ОТМЕНЕННЫЙ</span>:</td>
				<td class="td-text"><input class="radio" type="radio" name="state" value="-1" <?php if($ORDER['state'] == '-1') echo 'checked="checked"'; else echo ''; ?> /></td>
			</tr>
		</tbody>
	</table>
</div>	
<div class="block-header">Товары в заказе</div>
<div class="block">
	<table class="order" cellspacing="0" cellpadding="0" class="block" width="800px">
		<thead>
			<tr>
				<th style="width:80px;">id товара</th>
				<th>Название товара</th>
				<th style="width:200px;">Цена</th>
				<th style="width:100px;">Количество</th>
			</tr>
		</thead>
		<tbody>
			<?php
				for($i = 0, $cnt = count($ORDER['products']); $i < $cnt; $i++){
					($i != $cnt-1)? $style = 'style="border-bottom: 1px solid #bbb;"' : $style = '';
					$ORDER['products'][$i]['ds_price']=number_format($ORDER['products'][$i]['ds_price'],0,"."," ");
					$href = $ORDER['catalog_url'];
					for($catcnt = count($ORDER['products'][$i]['category']), $j = $catcnt-1; $j >= 0; $j--){
						$href.='/'.$ORDER['products'][$i]['category'][$j]['url'];
					}
					$href.='/'.$ORDER['products'][$i]['url'];
					echo '<tr '.$style.'>
								<td class="td-align-center">'.$ORDER['products'][$i]['id_product'].'</td>
								<td class="td-align-center"><a target="_blank" href="'.$href.'">'.$ORDER['products'][$i]['title'].'</a></td>
								<td class="td-align-center">'.$ORDER['products'][$i]['ds_price'].'</td>
								<td class="td-align-center">'.$ORDER['products'][$i]['count'].'</td>
						  </tr>';
				}
			?>
		</tbody>
	</table>
</div>
<input class="btn btn-inverse clear" type="submit" value="Сохранить" name="submit">
</form>
