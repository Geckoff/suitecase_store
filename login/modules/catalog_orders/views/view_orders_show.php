<script>
$('document').ready(function(){
	$('.chekitem').live('click',function(){
		$('.check-all img').attr('src','img/struct-content-check.png');
		if($(this).find('img').attr('src') == 'img/struct-content-check-active.png'){
			$(this).find('img').attr('src','img/struct-content-check.png');
			$(this).find('input').val('0');
		}
		else{
			$(this).find('img').attr('src','img/struct-content-check-active.png');
			$(this).find('input').val('1');
		}
	});
	$('.item').live('click',function(){
		window.location=$(this).closest('tr').attr('href');
	});

	$('.check-all img').live('click',function(){
		if($(this).attr('src') == 'img/struct-content-check-active.png'){
			$('.check-all img,.chekitem img').attr('src','img/struct-content-check.png');
			$('.chekitem').find('input').val('0');
		}
		else{
			$('.check-all img,.chekitem img').attr('src','img/struct-content-check-active.png');
			$('.chekitem').find('input').val('1');
		}
	});
	//keyup(pager)
	var total_page = <?php if(isset($_TOTAL_PAGE)) echo $_TOTAL_PAGE; else echo '0'; ?>;
	$('.pcount_up, .pcount_down').keyup(function(eventObject){
		if(eventObject.keyCode == 13){
			var page = 0;
			if($(this).val() % 1 !== 0){
				page = '<?php if(!isset($_PAGE) || empty($_PAGE) || !(int)$_PAGE) echo '1'; else echo $_PAGE;?>';
			} else{
				if($(this).val() < 1){
					page = 1;
				} else{
					if($(this).val() > total_page){
						page = total_page;
					}else {
						page = $(this).val();
					}
				}
			}
			if(page == 0 ){page = 1;}
			var url = '<?php if(isset($G['select']) && !empty($G['select'])) echo $URL.'&action=orders_show&select='.$G['select'].'&page='; else echo$URL.'&action=orders_show&select=all&page=';?>'+page;
			window.location = url;
		} else return false;
	});
});
</script>
<form action="<?php echo $URL,'&action=all_items_save&page=1';?>" method="post">
<div class="right_center_block_nastroiki">
	<div class="check-all"><img width="16" height="16" src="img/struct-content-check.png"></div>
	<div id="control-panel">
		<input type="submit" value="Новый" name="action">
		<input type="submit" value="Необработанный" name="action">
		<input type="submit" value="Выполненный" name="action">
		<input type="submit" value="Отмененный" name="action">
		<input type="hidden" value="" name="checkbox">
	</div>
	<div class="right_block_pi">
		<div id="navigate">
			<a href="<?php echo $URL,'&action=orders_show&select='.$G['select'].'&page=1'; ?>"><img src="img/struct-header-rollfirst.png"></a>
			<a href="<?php echo $URL,'&action=orders_show&select='.$G['select'].'&page='.($_PAGE == 1 ? 1 : $_PAGE - 1); ?>"><img src="img/struct-header-rollleft.png"></a>
			<span>Страница <input class='pcount_up' type="text" name="nextpage" value="<?php echo $_PAGE; ?>" size="3"> из <span><?php echo $_TOTAL_PAGE; ?></span></span>
			<a href="<?php echo $URL,'&action=orders_show&select='.$G['select'].'&page='.($_PAGE == $_TOTAL_PAGE ? $_TOTAL_PAGE : $_PAGE + 1); ?>"><img src="img/struct-header-rollright.png"></a>
			<a href="<?php echo $URL,'&action=orders_show&select='.$G['select'].'&page='.$_TOTAL_PAGE; ?>" style="margin-left:3px;"><img src="img/struct-header-rolllast.png"></a>
			<span style="display:block; margin-top:8px;">
				<a href="#" id="10" <?php if ((isset($_COOKIE['count']) and (int)$_COOKIE['count']=='10') or (!isset($_COOKIE['count']))) echo 'style="color:#FF861B;"'; else echo 'style="color:#555;"'; ?> class="count">10</a>
				| <a href="#" id="50" <?php if (isset($_COOKIE['count']) and (int)$_COOKIE['count']=='50') echo 'style="color:#FF861B;"'; else echo 'style="color:#555;"'; ?> class="count">50</a> 
				| <a href="#" id="100"   <?php if (isset($_COOKIE['count']) and (int)$_COOKIE['count']=='100') echo 'style="color:#FF861B;"'; else echo 'style="color:#555;"'; ?> class="count">100</a>
			</span>
		</div>
	</div> 
</div>
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="product_list height-65">
	<thead>
		<tr style="height:auto;">
			<th style="width:22px; text-align: center; border:none;"></th>
			<th style="width:40px; text-align: center; border:none;">№</th>
			<th style="width:50px; text-align: center; border:none;">Статус</th>
			<th style="text-align: center; border:none;">Имя</th>
			<th style="width:155px; text-align: center; border:none;">Телефон</th>
			<th style="text-align: center; border:none;">E-mail</th>
			<th style="width:80px; text-align: center; border:none;">Дата</th>
			<th style="width:110px; text-align: center; border:none;">Стоимость</th>
		</tr>
	</thead>
<tbody>
<?php
if(count($ORDERS) > 0){
	foreach ($ORDERS as $ORDERS_val){
		switch($ORDERS_val['state']){
		case '0':
			$src = 'img/unfinished.png';
			$title = 'Необработанный';
			$class='';
			break;
		case '1':
			$src = 'img/executed.png';
			$title = 'Выполненный';
			$class='';
			break;
		case '-1':
			$src = 'img/canceled.png';
			$title = 'Отмененный';
			$class='canceled-order';
			break;
		default :
			$src = 'img/new.png';
			$title = 'Новый';
			$class='new-order';
			break;
		}
		echo '<tr class="'.$class.'" href="'.$URL.'&action=order_edit&id='.$ORDERS_val['id'].'">
				<td class="chekitem"><img src="img/struct-content-check.png"><input type="hidden" name="checkbox['.$ORDERS_val['id'].']" value="0"></td>
				<td class="item">
					<div class="padding">
						<span>'.$ORDERS_val['id'].'</span>
					</div>
				</td>
				<td class="item"><img class="img" title="'.$title.'" alt="'.$title.'" src="'.$src.'"></td>
				<td class="item">'.$ORDERS_val['name'].'</td>
				<td class="item">'.$ORDERS_val['phone'].'</td>
				<td class="item">'.$ORDERS_val['email'].'</td>
				<td class="item">'.$ORDERS_val['date'].'</td>
				<td class="item">'.$ORDERS_val['price'].'</td>
			 </tr>';
	}
}
?>
</tbody>
</table>
<div class="right_center_block_nastroiki">
	<div class="check-all"><img width="16" height="16" src="img/struct-content-check.png"></div>
	<div id="control-panel">
		<input type="submit" value="Новый" name="action">
		<input type="submit" value="Необработанный" name="action">
		<input type="submit" value="Выполненный" name="action">
		<input type="submit" value="Отмененный" name="action">
	</div>
	<div class="right_block_pi">
		<div id="navigate">
			<a href="<?php echo $URL,'&action=orders_show&select='.$G['select'].'&page=1'; ?>"><img src="img/struct-header-rollfirst.png"></a>
			<a href="<?php echo $URL,'&action=orders_show&select='.$G['select'].'&page='.($_PAGE == 1 ? 1 : $_PAGE - 1); ?>"><img src="img/struct-header-rollleft.png"></a>
			<span>Страница <input class='pcount_down' type="text" name="nextpage" value="<?php echo $_PAGE; ?>" size="3"> из <span><?php echo $_TOTAL_PAGE; ?></span></span>
			<a href="<?php echo $URL,'&action=orders_show&select='.$G['select'].'&page='.($_PAGE == $_TOTAL_PAGE ? $_TOTAL_PAGE : $_PAGE + 1); ?>"><img src="img/struct-header-rollright.png"></a>
			<a href="<?php echo $URL,'&action=orders_show&select='.$G['select'].'&page='.$_TOTAL_PAGE; ?>" style="margin-left:3px;"><img src="img/struct-header-rolllast.png"></a>
			<span style="display:block; margin-top:8px;">
				<a href="#" id="10" <?php if ((isset($_COOKIE['count']) and (int)$_COOKIE['count']=='10') or (!isset($_COOKIE['count']))) echo 'style="color:#FF861B;"'; else echo 'style="color:#555;"'; ?> class="count">10</a>
				| <a href="#" id="50" <?php if (isset($_COOKIE['count']) and (int)$_COOKIE['count']=='50') echo 'style="color:#FF861B;"'; else echo 'style="color:#555;"'; ?> class="count">50</a> 
				| <a href="#" id="100"   <?php if (isset($_COOKIE['count']) and (int)$_COOKIE['count']=='100') echo 'style="color:#FF861B;"'; else echo 'style="color:#555;"'; ?> class="count">100</a>
			</span>
		</div>
	</div> 
</div>
</form>
