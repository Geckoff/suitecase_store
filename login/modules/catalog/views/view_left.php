<link href="css/catalog.css" rel="stylesheet" type="text/css" />
<script src="js/ui/jquery.ui.core.js" type="text/javascript"></script>
<script src="js/ui/jquery.ui.widget.js" type="text/javascript"></script>
<script src="js/ui/jquery.ui.mouse.js" type="text/javascript"></script>
<script src="js/ui/jquery.ui.draggable.js" type="text/javascript"></script>
<script src="js/ui/jquery.ui.sortable.js" type="text/javascript"></script>
<script src="js/catalog.js" type="text/javascript"></script>
<table cellspacing="0" cellpadding="0" width="100%">
	<tbody>
		<tr>
			<td>
				<div class="text" style="padding: 0px 0px 1px 10px">
					<a class="append_tree btn" id="append_tree_0" href="<?php print $URL.'&action=tree_append&into=0'; ?>">
						<i class="icon-plus-sign"></i>&nbsp;Добавить элемент в корень
					</a>
				</div>
				<div class="show_all">
					<a href="<?php print $URL.'&action=blank'; ?>">Все товары</a>
				</div>
			</td>
		</tr>
		<tr>
			<td>
				<div class="plus-all"><img src="img/struct-content-plus.png" alt="+" /></div>
				<div class="text open_all_plus">Открыть все пункты</div>
			</td>
		</tr>
		<?php
			echo getTree(0,1);
		?>
	</tbody>
</table>
