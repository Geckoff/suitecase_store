<style>
.group_sample
{
display:none;
}
.parameter_value
{
display:none;
}
</style>
<script type="text/javascript">
    function delete_inherited_param() { //удаление унаследованных
        $('div.ui-state-highlight').remove();
        $('div#all_parameters').empty();
        $('div.group_sample').clone().appendTo('div#all_parameters').attr('class', 'group');
        <?php if(isset($_SESSION['info'])){$_SESSIN['info']='';}?>
        $('div.alert').slideUp('fast');
        
    }
	
    function form_submit() {
        var group_id = 0;
        var param_id = 0;
        $('div#all_parameters div.group').each(function(){
            $(this).children('input.group_name').attr('name','groups['+group_id+'][name]');
            $(this).children('input.group_id').attr('name','groups['+group_id+'][id]');
            $(this).children('input.group_active').attr('name','groups['+group_id+'][active]');
            $(this).children('input.group_delete').attr('name','groups['+group_id+'][delete]');
            $(this).children('div.parameter').each(function(){
                $(this).children('input.parameter_name').attr('name','groups['+group_id+'][parameters]['+param_id+'][name]');
                $(this).children('input.parameter_id').attr('name','groups['+group_id+'][parameters]['+param_id+'][id]');
                $(this).children('input.parameter_active').attr('name','groups['+group_id+'][parameters]['+param_id+'][active]');
                $(this).children('input.parameter_delete').attr('name','groups['+group_id+'][parameters]['+param_id+'][delete]');
                $(this).children('select.parameter_type').attr('name','groups['+group_id+'][parameters]['+param_id+'][type]');
                param_id++;
            });
            group_id++;
            param_id = 0;
        });

        $('span.parameter_value:visible').each(function(){
            var data = '';
            $(this).children('select').children('option').each(function(){
               data = data + $(this).html() + '<|>' + $(this).attr('id') + '<->';
            });
            $(this).children('input').val(data);
        });

        return false;
    }

    /*	Втсака шаблона группа-параметр, если нет параметров
		<?php if((int)$_id == 0) echo "$('div.group_sample').clone().appendTo('div#all_parameters').attr('class', 'group');"; ?>
    */

    $('a.group_add').live('click',function(){ //добавление группы
        $('div.group_sample').clone().appendTo('div#all_parameters').attr('class', 'group');
        return false;
    });

    $('a.parameter_add').live('click',function(){ //добавление параметра в группу
        $('div.group_sample div.parameter').clone().insertBefore($(this).parent('div.add'));
        return false;
    });

    $('a.group_delete').live('click',function(){ //удаление группы
        if(confirm('Вы действительно хотите удалить?'))
            $(this).parent('div.delete').parent('div.group').css('display','none').find('.group_delete').val('1');
        return false;
    });

    $('a.parameter_delete').live('click',function(){ //удаление параметра в группе
        if($(this).parent('div.delete').parent('div.parameter').parent('div.group').children('div.parameter').length == 1) {
            alert('Нельзя удалить единтсвенный параметр в группе');
            return false;
        }
        if(confirm('Вы действительно хотите удалить?'))
            $(this).parent('div.delete').parent('div.parameter').css('display','none').find('.parameter_delete').val('1');
        return false;
    });
    
    
    $('img.group_active_img').live('click',function(){ //изменение активности группы
		if($(this).attr('src') == 'img/struct-content-check-active.png'){
			$(this).attr('src','img/struct-content-check.png');
			$(this).next().val('0');
			$(this).closest('.group').find('.parameter').each(function(i,el){
				$(el).find('img.parameter_active_img').attr('src','img/struct-content-check.png');
				$(el).find('img.parameter_active_img').next().val('0');
			});
		}
		else{
			$(this).attr('src','img/struct-content-check-active.png');
			$(this).next().val('1');
			$(this).closest('.group').find('.parameter').each(function(i,el){
				$(el).find('img.parameter_active_img').attr('src','img/struct-content-check-active.png');
				$(el).find('img.parameter_active_img').next().val('1');
			});
		}
	});
    $('img.parameter_active_img').live('click',function(){ //изменение активности /параметра
		if($(this).attr('src') == 'img/struct-content-check-active.png'){
			$(this).attr('src','img/struct-content-check.png');
			$(this).next().val('0');
		}
		else{
			$(this).attr('src','img/struct-content-check-active.png');
			$(this).next().val('1');
		}
	});
</script>
<div id="wrap-right">
	<form action="<?php echo $URL,'&action=parameters_save&id=',$G['id']; ?>" method="post" >
		<div class="block">
			<div class="group_sample">
				<div class="delete" id="delete" style="float:left; margin: 2px 4px 0px 0px;" >
					<a class="group_delete" href="#" title="Удалить"><img src="img/struct-content-delete.png" alt="✖"  /></a>
				</div>

				<img class="group_active_img" src="img/struct-content-check-active.png" alt="Активность группы">
				<input class="group_active" type="hidden" value="1" />
				<input class="group_delete" type="hidden" value="0" />
				<input class="group_id" type="hidden" value="" />
				<input class="group_name" type="text" value="Группа параметров" name="" />

				<div class="parameter">
					<div class="delete" id="delete" style="float:left; margin: 2px 4px 0px 0px;" >
						<a class="parameter_delete" href="#" title="Удалить"><img src="img/struct-content-delete.png" alt="✖" /></a>
					</div>

					<img class="parameter_active_img" src="img/struct-content-check-active.png" title="Активность параметра">
					<input class="parameter_active" type="hidden" value="1" />
					<input class="parameter_delete" type="hidden" value="0" />
					<input class="parameter_id" type="hidden" value="" />
					<input class="parameter_name" type="text" value="Параметр" name="" />

					<select class="parameter_type" style="width:100px;" name="">
						<option value="0">Текст</option>
						<option value="1">Есть/нет</option>
					</select>

				</div>
				<div class="add" id="add" style="margin: 0px 0px 0px 20px;clear:both;" >
					<a class="parameter_add" href="#" title="Добавить параметр" id="button"><img src="img/struct-content-add.png" alt="+" />Добавить параметр</a>
				</div>
			</div>

			<div id="all_parameters">
				<?php
				   if(count($PARAMETERS) > 0)
					   foreach($PARAMETERS as $_GROUP_val) { 
				?>
							<div class="group" >
								<div class="delete" id="delete" style="float:left; margin: 2px 4px 0px 0px;" >
									<a class="group_delete" href="#" title="Удалить"><img src="img/struct-content-delete.png" alt="✖" /></a>
								</div>

								<img class="group_active_img" src="img/struct-content-check<?php echo ((int)$_GROUP_val['active'] == 1 ? '-active' : ''); ?>.png" alt="Активность группы">
								<input class="group_active" type="hidden" value="<?php echo ((int)$_GROUP_val['active'] == 1 ? '1' : '0'); ?>" />
								<input class="group_delete" type="hidden" value="<?php echo ((int)$_GROUP_val['delete'] == 1 ? '1' : '0'); ?>" />
								<input class="group_id" type="hidden" value="<?php echo $_GROUP_val['id']; ?>" />
								<input class="group_name" type="text" value="<?php echo $_GROUP_val['name']; ?>" name="" />
						<?php
							foreach($_GROUP_val['parameters'] as $_PARAMS_val) { 
						?>
								<div class="parameter">
									<div class="delete" id="delete" style="float:left; margin: 2px 4px 0px 0px;" >
										<a class="parameter_delete" href="#" title="Удалить"><img src="img/struct-content-delete.png" alt="✖" /></a>
									</div>

									<img class="parameter_active_img" src="img/struct-content-check<?php echo ((int)$_PARAMS_val['active'] == 1 ? '-active' : ''); ?>.png" title="Активность параметра">
									<input class="parameter_active" type="hidden" value="<?php echo ((int)$_PARAMS_val['active'] == 1 ? '1' : '0'); ?>" />
									<input class="parameter_delete" type="hidden" value="<?php echo ((int)$_PARAMS_val['delete'] == 1 ? '1' : '0'); ?>" />
									<input class="parameter_id" type="hidden" value="<?php echo $_PARAMS_val['id']; ?>" />
									<input class="parameter_name" type="text" value="<?php echo $_PARAMS_val['title']; ?>" name="" />

									<select class="parameter_type" style="width:100px;" name="">
										<option value="0" <?php if((int)$_PARAMS_val['type'] == 0) echo 'selected'?>>Текст</option>
										<option value="1" <?php if((int)$_PARAMS_val['type'] == 1) echo 'selected'?>>Есть/нет</option>
									</select>
								</div>
						<?php
							}
						?>
								<div class="add" id="add" style="margin: 0px 0px 0px 20px;clear:both;" >
									<a class="parameter_add" href="#" title="Добавить параметр" id="button"><img src="img/struct-content-add.png" alt="+" />Добавить параметр</a>
								</div>
							</div>
				<?php
						}
				?>
			</div>
			<div class="add add_param" id="add" >
				<a class="group_add" href="#" title="Добавить группу параметров" id="button"><img src="img/struct-content-add.png" alt="+" />Добавить группу параметров</a>
			</div>
		</div>
		<input type="submit" class="btn btn-inverse clear" value="Сохранить" onclick="form_submit();" />
	</form>
</div>
