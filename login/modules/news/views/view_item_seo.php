<div class="block">
	<table cellspacing="0" cellpadding="0" class="block" width="100%">
	<tr>
		<td class="text">Title (заголовок)</td>
		<td>
			<input type="text" name="seo[title]" value="<?php if (isset($ITEM['seo_title'])) echo htmlspecialchars($ITEM['seo_title']); ?>" />
		</td>
	</tr>
	<tr>
		<td class="text">Keywords (ключевые слова)</td>
		<td>
			<input type="text" name="seo[keywords]" value="<?php if (isset($ITEM['seo_keywords'])) echo htmlspecialchars($ITEM['seo_keywords']); ?>" />
		</td>
	</tr>
	<tr>
		<td class="text">Description (описание страницы)</td>
		<td>
			<textarea name="seo[description]" rows="5"><?php if (isset($ITEM['seo_description'])) echo htmlspecialchars($ITEM['seo_description']); ?></textarea>
		</td>
	</tr>
	</table>
</div>
