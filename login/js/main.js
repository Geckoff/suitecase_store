/*
 * @author ООО "Фабрика проектов"
 * @copyright 2013
 */
$(function() {
	
    // TinyMCE ---------------------------------
    tinymce.PluginManager.load('moxiecut', '/tinymce/plugins/moxiecut/plugin.min.js');
    tinymce.init({
        language : "ru",
        selector : "#tmce1, #tmce2, #tmce3",
        theme: "modern",
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste moxiecut"
        ],
        toolbar1: "undo redo | styleselect fontselect fontsizeselect | bold italic underline strikethrough | forecolor backcolor",
        toolbar2: "outdent indent | bullist numlist | alignleft aligncenter alignright alignjustify | link unlink | insertfile image media | hr nonbreaking | code preview ",
    });  

	// Сворачивание-разворачивание структуры ---------------------------------
	if ($.cookie('structRollleft')) {
		$('div#structLayout').css('margin-left', '-265px');
		$('div#structLayout a#roll-left img').attr('src', 'img/struct-header-rollright.png');
	}
	$('div#structLayout a#roll-left').click(function(){
		if ($.cookie('structRollleft')) {
			$('div#structLayout').animate({
				marginLeft: '0px'
				}, 'normal', 'swing', function(){
					$('div#structLayout a#roll-left img').attr('src', 'img/struct-header-rollleft.png');
				}
			);
			$.cookie('structRollleft', null);
		}
		else {
			$.cookie('structRollleft', '1', {expires: 365, path: '/', domain: ''});
			$('div#structLayout').animate({
				marginLeft: '-265px'
				}, 'normal', 'swing', function(){
					$('div#structLayout a#roll-left img').attr('src', 'img/struct-header-rollright.png');
				}
			);
		}
		return false;
	});
    $('.plus-all').next().click(function(){
        $(this).prev().find('img').click();
    });


    // Загрузка состояния структуры из cookies ---------------------------------
    function load_tree_state(){
        var str = $.cookie('tree_state_'+window.module_id);
        if (str != null) {
            var i = 1;
            var mas;
            mas = str.split(',');
            $('div#content table tr.tree_row').each(function(){
                if(i == mas[0]) {
                    $(this).children('td.in').children().show();
                    $(this).prev('tr.tree_row').children('td').children('div.plus').children().attr('src', 'img/struct-content-minus.png')
                    $(this).prev('tr.tree_row').children('td').children('div.icon').find('img').attr('src', 'img/struct-content-folder-empty.png');
                    mas.shift();
                }
                i++;
            });	
        }
    }


    // Запись состояния структуры в cookies ---------------------------------
    function save_tree_state(){
        var i = 1;
        var mas = Array();
        $('div#content table tr.tree_row').each(function(){
            if($(this).children('td.in').children().is(':visible'))
                mas.push(i);
            i++;
        });
        $.cookie('tree_state_'+window.module_id, mas.join(','), {expires: 365, path: '/', domain: ''});
        
    }

	
	// Уровни структуры ---------------------------------
	$('div#structLayout div#content td:first').css('border-top', 'solid 1px #D5E1E5');
	$('div#structLayout div#content td').css('border-bottom', 'solid 1px #D5E1E5');
	$('div#structLayout div#content td.in').css('border-bottom', 'none').children().hide();
	$('div#structLayout div#content div.plus img').click(function(){
		if ($(this).parent().parent().parent().next('tr').children().children().is(':visible')) {
			$(this).parent().next().find('img').attr('src', 'img/struct-content-pagefolder.png');
			$(this).attr('src', 'img/struct-content-plus.png');
			$(this).attr('alt', '+');
		} else {
			$(this).parent().next().find('img').attr('src', 'img/struct-content-folder-empty.png');
			$(this).attr('src', 'img/struct-content-minus.png');
			$(this).attr('alt', '-');
		}
		$(this).parent().parent().parent().next('tr').children().children().slideToggle('fast');
                window.setTimeout(save_tree_state, 800);
	});
 	$('div#structLayout div#content div.plus-all img').click(function(){
		if ($(this).attr('src') == 'img/struct-content-plus.png') {
			$('div#structLayout div#content div.plus img').each(function(){
				if ($(this).attr('src') == 'img/struct-content-plus.png')
					$(this).trigger('click');
			});
			$(this).attr('src', 'img/struct-content-minus.png');
			$(this).parent().next().html('Закрыть все пункты');
		}
		else {
			$('div#structLayout div#content div.plus img').each(function(){
				if ($(this).attr('src') == 'img/struct-content-minus.png')
					$(this).trigger('click');
			});
			$(this).attr('src', 'img/struct-content-plus.png');
			$(this).parent().next().html('Открыть все пункты');
		}
	});

	
	// Наведение активный пункт структуры ---------------------------------
	$('div.structLayout div#content td:not(#in)').hover(function(){
	   	$(this).addClass('active-menu');
	},
	function() {
	    $(this).removeClass('active-menu');
	});


	// стрелки в каталоге ---------------------------------
	$('#navigate a img').hover(function()
	{
		if ($(this).attr('src')=='img/struct-header-rollleft.png')
		{
			$(this).attr('src','img/struct-header-rollleft-hover.png');
		}
		else if($(this).attr('src')=='img/struct-header-rollfirst.png')
		{
			$(this).attr('src','img/struct-header-rollfirst-hover.png');
		}
		else if($(this).attr('src')=='img/struct-header-rollright.png')
		{
			$(this).attr('src','img/struct-header-rollright-hover.png');
		}
		else
		{
			$(this).attr('src','img/struct-header-rolllast-hover.png');
		}
	},
	function()
	{
		if ($(this).attr('src')=='img/struct-header-rollleft-hover.png')
		{
			$(this).attr('src','img/struct-header-rollleft.png');
		}
		else if($(this).attr('src')=='img/struct-header-rollfirst-hover.png')
		{
			$(this).attr('src','img/struct-header-rollfirst.png');
		}
		else if($(this).attr('src')=='img/struct-header-rollright-hover.png')
		{
			$(this).attr('src','img/struct-header-rollright.png');
		}
		else
		{
			$(this).attr('src','img/struct-header-rolllast.png');
		}
	});
	
	$('.vano-tebl div.up').css('opacity', '0.5');
	$('.vano-tebl div.down').css('opacity', '0.5');
	$('.vano-tebl div.up').hover(function(){
		$(this).css('opacity', '1');
	},
	function(){
		$(this).css('opacity', '0.5');
	});
	$('.vano-tebl div.down').hover(function(){
		$(this).css('opacity', '1');
	},
	function(){
		$(this).css('opacity', '0.5');
	});
	
	// переключить количество товаров на страницу
	$('a.count').click(function()
	{
		var count=$(this).attr('id');
		$.cookie('count', count, {expires: 365, path: '/', domain: ''});
		window.location.reload();
		return false;
	});

    
	// Загрузка состояния структуры из cookies ---------------------------------
    load_tree_state();
});
