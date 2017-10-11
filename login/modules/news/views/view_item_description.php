<script type="text/javascript">
  $(function() {
    $('#datetimepicker').datetimepicker({
      language: 'ru',
      maskInput: true,
      pickTime: true,
      endDate: Date()
    });
  });
</script>
<div class="block">
	<table cellspacing="0" cellpadding="0" class="block" width="100%">
		<tr>
            <td class="text">Заголовок новости</td>
            <td>
                <input type="text" name="description[title]" value="<?php if (isset($ITEM['title'])) echo htmlspecialchars($ITEM['title']); ?>" />
            </td>
        </tr>
		<tr>
            <td class="text">Дата публикации</td>
            <td>
				<div id="datetimepicker" class="date">
					<input data-format="dd.MM.yyyy hh:mm"  type="text" name="description[date]" value="<?php if (isset($ITEM['date'])) echo date('d.m.Y H:i',$ITEM['date']); else echo  date('d.m.Y H:i',time()); ?>" />
					<span class="add-on">
						<i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
					</span>
				</div>
			</td>
        </tr>
        <tr>
            <td class="text">Анонс</td>
            <td>
                <textarea name="description[announcement]" rows="5"><?php if (isset($ITEM['announcement'])) echo htmlspecialchars($ITEM['announcement']); ?></textarea>
            </td>
        </tr>
        <tr>
            <td class="text">Полное описание новости</td>
            <td>
                <textarea name="description[description]" <?php if($Config['common']['editor'] == true) echo 'id="tmce1" cols="80" rows="20"'; else echo 'rows="5"'; ?>><?php if (isset($ITEM['description'])) echo htmlspecialchars($ITEM['description']); ?></textarea>
            </td>
        </tr>
        <tr>
            <td class="text">Выделить новость</td>
            <td>
				<img class="default check" value="<?php if(isset($ITEM['check'])) echo (int)$ITEM['check']; else echo ''; ?>" src="">
                <input type="hidden" name="description[check]" value="0" />
            </td>
        </tr>
        <tr>
            <td class="text">Активность</td>
            <td>
				<img class="default-active check" value="<?php if(isset($ITEM['active'])) echo (int)$ITEM['active']; else echo ''; ?>" src="">
                <input type="hidden" name="description[active]" value="0" />
            </td>
        </tr>
	</table>
</div>
