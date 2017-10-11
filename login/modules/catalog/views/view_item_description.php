<script>
$('document').ready(function(){
	
	// Number field type (INT/FLOAT)
	$('#price, #ds-price').keyup(function(){
        CheckNumberFields(this, 'int', '');
    }).change(function(){
        CheckNumberFields(this, 'int', '');
    });
	$('#ds-val').keyup(function(){
        CheckNumberFields(this, 'int', '');
    }).change(function(){
        CheckNumberFields(this, 'int', '');
    });
	
	//DISCOUNT BLOCK
	$('#discount-state').live('click',function(){
		if($(this).attr('src') == 'img/struct-content-check-active.png'){
			$(this).attr('src','img/struct-content-check.png');
			$(this).next().val('0');
			$('.discount').css('display','none');
		}
		else {
			$(this).attr('src','img/struct-content-check-active.png');
			$(this).next().val('1');
			$('.discount').css('display','block');
		}
	});
	if($('#discount-state').attr('value') == '1'){	$('.discount').css('display','block');	}
	var ds_type = '<?php if(isset($ITEM['ds_type']) && $ITEM['ds_type'] == '1') echo 'persent'; else echo 'numeric'; ?>';
	var ds_value = '<?php if(isset($ITEM['ds_value'])) echo $ITEM['ds_value']; ?>';
	$('#ds-type option').each(function(i,el){
		if($(el).val() == ds_type){
			$(el).attr('selected','selected');
		}
	});
	$('#ds-value option').each(function(i,el){
		if($(el).val() == ds_value){
			$(el).attr('selected','selected');
		}
	});
	if(ds_type == 'persent'){ 
		$('.ifpersent').removeClass('ds-value');
		$('#ds-price').attr('disabled','disabled');
	}
	if(ds_value == 'none'){ 
		$('.half-mr').css('display','inline-block');
	}
	
	// Изменение типа скидки
	$('#ds-type').live('change',function(){
		if($(this).val() == 'persent'){
			var price = $('#price').val(),
				dsVal = $('#ds-val').val(),
				dsValue = $('#ds-value').val(),
				dsPriceEl = $('#ds-price');	
			$('.ifpersent').removeClass('ds-value');
			$('#ds-price').attr('disabled','disabled');
			if($('#ds-value option:selected').val() == 'none'){
				if(price != '' && dsVal != ''){
					dsPriceEl.val(Math.ceil(price * (1 - dsVal / 100)));
				} else{
					dsPriceEl.val('');
				}
			} else{
				if(price != ''){
					dsPriceEl.val(Math.ceil(price * (1 - dsValue / 100)));
				} else{
					dsPriceEl.val('');
				}
			}
		} else{
			$('.ifpersent').addClass('ds-value');
			$('#ds-price').removeAttr('disabled');
		}
	});
	
	// Изменение значения процента скидки
	$('#ds-value').change(function(){
		var price = $('#price').val(),
			dsVal = $('#ds-val').val(),
			dsValue = $('#ds-value').val(),
			dsPriceEl = $('#ds-price');		
		if($(this).val() == 'none'){
			$('.half-mr').css('display','inline-block');
			if(price != '' && dsVal != ''){
				dsPriceEl.val(Math.ceil(price * (1 - dsVal / 100)));
			} else{
				dsPriceEl.val('');
			}
		} else{
			$('.half-mr').css('display','none');
			if(price != ''){
				dsPriceEl.val(Math.ceil(price * (1 - dsValue / 100)));
			} else{
				dsPriceEl.val('');
			}
		}
	});
	
	// Ввод пользовательского значения процента скидки
	$('#ds-val').keyup(function(){
		$(this).change();
	}).change(function(){
		var price = $('#price').val(),
			dsVal = $('#ds-val').val(),
			dsPriceEl = $('#ds-price');
		if(price != '' && dsVal != ''){
			dsPriceEl.val(Math.ceil(price * (1 - dsVal / 100)));
		} else{
			dsPriceEl.val('');
		}
	});
	
	// Изменение цены
	$('#price').keyup(function(){
		$(this).change();
	}).change(function(){
		var price = $('#price').val(),
			dsVal = $('#ds-val').val(),
			dsValue = $('#ds-value').val(),
			dsPriceEl = $('#ds-price');
		if(price != ''){
			if($('#ds-type').val() == 'persent'){
				if(dsValue == 'none' ){ //ds-val
					dsPriceEl.val(Math.ceil(price * (1 - dsVal / 100)));
				} else { //ds-value
					dsPriceEl.val(Math.ceil(price * (1 - dsValue / 100)));
				}
			}
			
		} else{
			dsPriceEl.val('');
		}
	});
});
</script>
<div class="block">
	<table cellspacing="0" cellpadding="0" class="block" width="100%">
		<tr>
            <td class="text">Название</td>
            <td>
                <input type="text" name="description[title]" value="<?php if (isset($ITEM['title'])) echo htmlspecialchars($ITEM['title']); ?>" />
            </td>
        </tr>
        <tr>
            <td class="text">Описание</td>
            <td>
                <textarea name="description[description]" <?php if($Config['common']['editor'] == true) echo 'id="tmce1" cols="80" rows="20"'; else echo 'rows="5"'; ?>><?php if (isset($ITEM['description'])) echo htmlspecialchars($ITEM['description']); ?></textarea>
            </td>
        </tr>
		<?php
			if($Config['section']['price'] == true){
				(isset($ITEM['price']))? $iBuff = $ITEM['price'] : $iBuff = '';
				echo '<tr><td class="text">Цена</td><td><input type="text" id="price" name="description[price]" value="'.$iBuff.'" /></td></tr>';
			} else echo '<tr><td class="void"><input type="hidden" name="description[price]" value="" /></td></tr>';
			if($Config['section']['featured'] == true){
				(isset($ITEM['featured']))? $iBuff = (int)$ITEM['featured'] : $iBuff = '';
				echo '<tr><td class="text">Рекомендуемый товар</td><td><img class="default check" value="'.$iBuff.'" src="">
					<input type="hidden" name="description[featured]" value="0" /></td></tr>';
			} else echo '<tr><td class="void"><input type="hidden" name="description[featured]" value="0" /></td></tr>';
			if($Config['section']['special'] == true){
				(isset($ITEM['special']))? $iBuff = (int)$ITEM['special'] : $iBuff = '';
				echo '<tr><td class="text">Спецпредложение</td><td><img class="default check" value="'.$iBuff.'" src="">
					<input type="hidden" name="description[special]" value="0" /></td></tr>';
			} else echo '<tr><td class="void"><input type="hidden" name="description[special]" value="0" /></td></tr>';
			if($Config['section']['price'] == true && $Config['section']['discount'] == true){
				(isset($ITEM['discount']))? $iBuff = (int)$ITEM['discount'] : $iBuff = '';
				echo '<tr><td class="text">Скидка</td><td><img id="discount-state" class="default" value="'.$iBuff.'" src="">
					<input type="hidden" name="description[discount][discount]" value="0" /></td></tr>';
			} else echo '<tr><td class="void"><input type="hidden" name="description[discount][discount]" value="0" /></td></tr>';
			if($Config['section']['available'] == true){
				(isset($ITEM['available']))? $iBuff = (int)$ITEM['available'] : $iBuff = '';
				echo '<tr><td class="text">В наличии</td><td><img class="default-active check" value="'.$iBuff.'" src="">
					<input type="hidden" name="description[available]" value="0" /></td></tr>';
			} else echo '<tr><td class="void"><input type="hidden" name="description[available]" value="1" /></td></tr>';
		
		?>
        <tr>
            <td class="text">Активность</td>
            <td>
				<img class="default-active check" value="<?php if(isset($ITEM['active'])) echo (int)$ITEM['active']; else echo ''; ?>" src="">
                <input type="hidden" name="description[active]" value="0" />
            </td>
        </tr>
	</table>
</div>
<div class="block-header discount">Скидка</div>
<div class="block discount">
	<table cellspacing="0" cellpadding="0" class="block" width="100%">
		<tr>
            <td class="text">Тип скидки:</td>
            <td>
				<select id="ds-type" name="description[discount][type]">
					<option value="numeric" >числовое значение</option>
					<option value="persent" >в процентах</option>
				</select>
            </td>
        </tr>
        <tr id="half-width" class="ifpersent ds-value">
			<td class="text">Размер скидки:</td>
			<td>
				<input id="ds-val" class="half-mr" type="text" name="description[discount][user_value]" value="<?php if(isset($ITEM['ds_user_value'])) echo $ITEM['ds_user_value']; ?>" />
				<select id="ds-value" class="half" name="description[discount][value]">
					<option value="1" >1% от цены</option>
					<option value="3" >3% от цены</option>
					<option value="5" >5% от цены</option>
					<option value="7" >7% от цены</option>
					<option value="10" >10% от цены</option>
					<option value="15" >15% от цены</option>
					<option value="20" >20% от цены</option>
					<option value="30" >30% от цены</option>
					<option value="50" >50% от цены</option>
					<option value="none" >Свое значение</option>
				</select>
			</td>
        </tr>
        <tr>
			<td class="text">Цена со скидкой:</td>
            <td>
				<input id="ds-price" class="price" type="text" name="description[discount][price]" value="<?php if(isset($ITEM['ds_price'])) echo $ITEM['ds_price']; ?>" />
            </td>
        </tr>
    </table>
</div>
