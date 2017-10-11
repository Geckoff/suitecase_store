<div id="wrap-right">
	<form action="<?php echo $URL.'&action=total_save&id_tree='.$_ID_TREE;?>" method="post">
		<input id="np" type="hidden" value="<?php if(!isset($_PAGE) || empty($_PAGE) || !(int)$_PAGE) echo '1'; else echo $_PAGE; ?>">
		<input id="tp" type="hidden" value="<?php if(!isset($_TOTAL_PAGE) || empty($_TOTAL_PAGE) || !(int)$_TOTAL_PAGE) echo '1'; else echo $_TOTAL_PAGE; ?>">
		<input id="url" type="hidden" value="<?php echo $URL.'&action='.$action.'&id_tree='.$_ID_TREE.'&orderby='.$_orderby.'&page=';?>">
		<div class="right_center_block_nastroiki">
			<div class="check-all"><img width="16" height="16" src="img/struct-content-check.png"></div>
			<?php if($_ID_TREE > 0) echo '<a id="add_button" class="btn btn-inverse clear" href="'.$URL.'&action=item_append&into='.$_ID_TREE.'">Добавить</a>'; ?>
			<div id="control-panel">
				<input type="submit" value="Показать" name="action">
				<input type="submit" value="Скрыть" name="action">
				<input type="submit" value="Удалить" name="action">
				<input type="submit" value="Показать не активные" name="action">
				<input type="submit" value="Показать все" name="action">
				<input type="hidden" value="" name="checkbox">
			</div>
			<div class="right_block_pi">
				<div id="navigate">
					<a href="<?php echo $URL.'&action='.$action.'&id_tree='.$_ID_TREE.'&orderby='.$_orderby.'&page=1'; ?>"><img src="img/struct-header-rollfirst.png"></a>
					<a href="<?php echo $URL.'&action='.$action.'&id_tree='.$_ID_TREE.'&orderby='.$_orderby.'&page='.($_PAGE == 1 ? 1 : $_PAGE - 1); ?>"><img src="img/struct-header-rollleft.png"></a>
					<span>Страница <input class='pcount_up' type="text" name="nextpage" value="<?php echo $_PAGE; ?>" size="3"> из <span><?php echo $_TOTAL_PAGE; ?></span></span>
					<a href="<?php echo $URL.'&action='.$action.'&id_tree='.$_ID_TREE.'&orderby='.$_orderby.'&page='.($_PAGE == $_TOTAL_PAGE ? $_TOTAL_PAGE : $_PAGE + 1); ?>"><img src="img/struct-header-rollright.png"></a>
					<a href="<?php echo $URL.'&action='.$action.'&id_tree='.$_ID_TREE.'&orderby='.$_orderby.'&page='.$_TOTAL_PAGE; ?>" style="margin-left:3px;"><img src="img/struct-header-rolllast.png"></a>
					<span style="display:block; margin-top:8px;">
						<a href="#" id="10" <?php if ((isset($_COOKIE['count']) and (int)$_COOKIE['count']=='10') or (!isset($_COOKIE['count']))) echo 'style="color:#FF861B;"'; else echo 'style="color:#555;"'; ?> class="count">10</a>
						| <a href="#" id="50" <?php if (isset($_COOKIE['count']) and (int)$_COOKIE['count']=='50') echo 'style="color:#FF861B;"'; else echo 'style="color:#555;"'; ?> class="count">50</a> 
						| <a href="#" id="100"   <?php if (isset($_COOKIE['count']) and (int)$_COOKIE['count']=='100') echo 'style="color:#FF861B;"'; else echo 'style="color:#555;"'; ?> class="count">100</a>
					</span>
				</div>
			</div> 
		</div>
		<table width="100%" cellspacing="0" cellpadding="0" border="0" class="product_list">
			<thead>
				<tr>
					<th style="width:22px; text-align: center; border:none;"></th>
					<th style="width:40px; text-align: center; border:none;">№</th>
					<th style="width:110px; text-align: center; border:none;">Изображение</th>
					<th style="width:280px; text-align: center; border:none;">Название</th>
					<th style="border:none;">Описание</th>
				</tr>
			</thead>
			<tbody>
			<?php
				echo $_buff;
			?>
			</tbody>
		</table>
		<div class="right_center_block_nastroiki">
			<div class="check-all"><img width="16" height="16" src="img/struct-content-check.png"></div>
			<?php if($_ID_TREE > 0) echo '<a id="add_button" class="btn btn-inverse clear" href="'.$URL.'&action=item_append&into='.$_ID_TREE.'">Добавить</a>'; ?>
			<div id="control-panel">
				<input type="submit" value="Показать" name="action">
				<input type="submit" value="Скрыть" name="action">
				<input type="submit" value="Удалить" name="action">
				<input type="submit" value="Показать не активные" name="action">
				<input type="submit" value="Показать все" name="action">
			</div>
			<div class="right_block_pi">
				<div id="navigate">
					<a href="<?php echo $URL.'&action='.$action.'&id_tree='.$_ID_TREE.'&orderby='.$_orderby.'&page=1'; ?>"><img src="img/struct-header-rollfirst.png"></a>
					<a href="<?php echo $URL.'&action='.$action.'&id_tree='.$_ID_TREE.'&orderby='.$_orderby.'&page='.($_PAGE == 1 ? 1 : $_PAGE - 1); ?>"><img src="img/struct-header-rollleft.png"></a>
					<span>Страница <input class='pcount_up' type="text" name="nextpage" value="<?php echo $_PAGE; ?>" size="3"> из <span><?php echo $_TOTAL_PAGE; ?></span></span>
					<a href="<?php echo $URL.'&action='.$action.'&id_tree='.$_ID_TREE.'&orderby='.$_orderby.'&page='.($_PAGE == $_TOTAL_PAGE ? $_TOTAL_PAGE : $_PAGE + 1); ?>"><img src="img/struct-header-rollright.png"></a>
					<a href="<?php echo $URL.'&action='.$action.'&id_tree='.$_ID_TREE.'&orderby='.$_orderby.'&page='.$_TOTAL_PAGE; ?>" style="margin-left:3px;"><img src="img/struct-header-rolllast.png"></a>
					<span style="display:block; margin-top:8px;">
						<a href="#" id="10" <?php if ((isset($_COOKIE['count']) and (int)$_COOKIE['count']=='10') or (!isset($_COOKIE['count']))) echo 'style="color:#FF861B;"'; else echo 'style="color:#555;"'; ?> class="count">10</a>
						| <a href="#" id="50" <?php if (isset($_COOKIE['count']) and (int)$_COOKIE['count']=='50') echo 'style="color:#FF861B;"'; else echo 'style="color:#555;"'; ?> class="count">50</a> 
						| <a href="#" id="100"   <?php if (isset($_COOKIE['count']) and (int)$_COOKIE['count']=='100') echo 'style="color:#FF861B;"'; else echo 'style="color:#555;"'; ?> class="count">100</a>
					</span>
				</div>
			</div> 
		</div>
	</form>
</div>
