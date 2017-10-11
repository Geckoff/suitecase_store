<div id="wrap-right">

<form method="POST" action="<?php echo $URL; ?>&action=save">

		<div class="block-header">Свойства записи</div>
		<div class="block">
			<table cellspacing="0" cellpadding="0" class="block" width="100%">
			<tr>
				<td class="text">Заголовок</td>
				<td>
					<input type="text" name="title" value="<?php if (isset($ITEM[0]['name'])) echo htmlspecialchars($ITEM[0]['name']); ?>" />
				</td>
			</tr>
			<tr>
				<td class="text">Значение</td>
				<td>
					<input type="text" name="value" value="<?php if (isset($ITEM[0]['value'])) echo htmlspecialchars($ITEM[0]['value']); ?>" />
				</td>
			</tr>
			</table>
		</div>
		<div style="clear:both;"></div>
		<input class="btn btn-inverse clear" type="submit" name="submit" value="Сохранить" />

	<input type="hidden" name="id" value="<?php if (isset($G['id'])) echo $G['id']; ?>" />
	<input type="hidden" name="parent" value="<?php if (isset($G['parent'])) echo $G['parent']; ?>" />
</form>

</div>