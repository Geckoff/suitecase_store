<div id="wrap-right">
	<div class="block-header">Свойства</div>
	<?php 
		if (isset($__STRUCT[0]['id'])) {
			print '<form method="POST" action="'.$URL.'&action=editstructpost">';
			print '<input type="hidden" name="id" value="'.$__STRUCT[0]['id'].'">';
		}
		else {
            print '<form method="POST" action="'.$URL.'&action=addstructpost">';
        }
		if (isset($_substruct)) {
            print '<input type="hidden" name="substruct" value="'.$_substruct.'">';
        }
		else {
			print '<input type="hidden" name="substruct" value="0">';
        }
	?>
	<div class="block">
		<table cellspacing="0" cellpadding="0" class="block" width="100%">
		<tr>
			<td class="text">Название пункта в меню</td>
			<td>
				<input type="text" id="menu_title" class="menu_title" name="menu_title" value="<?php if (isset($__STRUCT[0]['menu_title'])) print htmlspecialchars($__STRUCT[0]['menu_title']); ?>" />
			</td>
		</tr>
		<tr>
			<td class="text">Заголовок страницы</td>
			<td>
				<input type="text" id="title" class="title" name="title" value="<?php if (isset($__STRUCT[0]['title'])) print htmlspecialchars($__STRUCT[0]['title']); ?>" />
			</td>
		</tr>
		<tr <?php if (!isset($__STRUCT[0]['name'])) print 'style="display: none;"'; ?>>
			<td class="text">Адрес страницы</td>
			<td>
				<input type="text" id="name" class="name" name="name" value="<?php if (isset($__STRUCT[0]['name'])) print htmlspecialchars($__STRUCT[0]['name']); ?>" />
                <br />
				<span class="text-simple">или перенаправление на другой адрес (URL)<br /> 
				<input type="text" id="name_url" class="name_url" name="name_url" value="<?php if (isset($__STRUCT[0]['url'])) print $__STRUCT[0]['url']; ?>" /></span>
			</td>
		</tr>
		<tr <?php if (!isset($__STRUCT[0]['name'])) print 'style="display: none;"'; ?> >
			<td class="text">Полный адрес страницы</td>
			<td>
				<?php
					if (isset($__STRUCT[0]['name']))
					{
						if ($__STRUCT[0]['url'] != '') print '<a class="page-url" href="'.$__STRUCT[0]['url'].'">'.$__STRUCT[0]['url'].'</a>';
						else print '<a class="page-url" href="'.$AdminConfig['HOST'].'/'.$__STRUCT[0]['name'].'">'.$AdminConfig['HOST'].'/'.$__STRUCT[0]['name'].'</a>';
					}
				?>
			</td>
		</tr>
		
    <?php
        $i = 0;
        $_flag = true;
        if (isset($__RELATION[0]))
        {
        	$_count = count($__RELATION);
        	for($i = 0; $i < $_count; $i++)
        	{
        		if ($__RELATION[$i]['id_module'] == 0 && $i == 0) 
        			$_flag = false;
    ?>
	<tr>
		<td class="text">Связь с разделом <?php print $i + 1; ?></td>
		<td>
			<select name="module[<?php print $__RELATION[$i]['id']; ?>]">
				<option value="0">---</option>
				<?php
					foreach ($_Menu as $_MenuVal) {
						if ($_MenuVal['name'] == 'structure' || $_MenuVal['name'] == 'menu') continue;
						if ($__RELATION[$i]['id_module'] == $_MenuVal['id'])
							$_selected = ' selected';
						else
							$_selected = '';
						print '<option value="'.$_MenuVal['id'].'"'.$_selected.'>'.$_MenuVal['title'].'</option>';
					}
				?>
			</select>
		</td>
	</tr>
	<?php
        if (isset($__STRUCT[0]['name'])) {
	?>
	<tr>
		<td class="text">Связь со структурой раздела</td>
		<td>
			<select name="module_table[<?php print $__RELATION[$i]['id']; ?>]">
				<option value="0">---</option>
				<?php
				foreach ($__RELATION[$i]['module_table'] as $__MT)
				{
					if ($__RELATION[$i]['id_main_field'] == $__MT['id'])
						$_selected = ' selected';
					else
						$_selected = '';
					print '<option value="'.$__MT['id'].'"'.$_selected.'>'.$__MT['main_field'].'</option>';
				}
				?>
			</select>
		</td>
	</tr>
    <?php 	
        		}
        	}
        }
       	if ($_flag) {
    ?>
		<tr>
			<td class="text">Связь с новым разделом</td>
			<td>
				<select name="module[-1]">
					<option value="0">---</option>
					<?php
						foreach ($_Menu as $_MenuVal)
						{
							if ($_MenuVal['name'] == 'structure' || $_MenuVal['name'] == 'menu') continue;
							print '<option value="'.$_MenuVal['id'].'">'.$_MenuVal['title'].'</option>';
						}
					?>
				</select>
			</td>
		</tr>
    <?php
    	}
    ?>
		</table>
	</div>
	
	<div class="block-header">Мета-теги для SEO-оптимизации</div>
	<div class="block">
		<table cellspacing="0" cellpadding="0" class="block" width="100%">
			<tr>
				<td class="meta-text">Title (заголовок)</td>
				<td>
					<input type="text" name="meta_title" value="<?php if (isset($__STRUCT[0]['meta_title'])) print htmlspecialchars($__STRUCT[0]['meta_title']); ?>" />
				</td>
			</tr>
			<tr>
				<td class="meta-text">Keywords (ключевые слова)</td>
				<td>
					<input type="text" name="meta_keywords" value="<?php if (isset($__STRUCT[0]['meta_keywords'])) print htmlspecialchars($__STRUCT[0]['meta_keywords']); ?>" />
				</td>
			</tr>
			<tr>
				<td class="meta-text">Description (описание страницы)</td>
				<td>
					<textarea rows="5" name="meta_description"><?php if (isset($__STRUCT[0]['meta_description'])) print htmlspecialchars($__STRUCT[0]['meta_description']); ?></textarea>
				</td>
			</tr>
		</table>
	</div>
	<div class="block-header">Наполнение страницы</div>
	<div class="block">
		<table cellspacing="0" cellpadding="0" class="block" width="100%">
		<tr>
			<td class="text">Текст страницы</td>
			<td>
				<textarea id="tmce1" cols="80" rows="20" name="text"><?php if (isset($__STRUCT[0]['text'])) print htmlspecialchars($__STRUCT[0]['text']); ?></textarea>
			</td>
		</tr>
		</table>
	</div>
	<input class="btn btn-inverse clear" type="submit" name="submit" value="Сохранить" />
   </form>
</div>  
