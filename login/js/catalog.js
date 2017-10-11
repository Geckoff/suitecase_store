function tree_append(obj){
	var new_tree = '';
	new_tree = prompt('Введите заголовок');
	if(typeof(new_tree) == 'object' || $.trim(new_tree) == '')
		return false;
	window.location.href = $(obj).attr('href') + '&title=' + new_tree;
}
function CheckNumberFields(el, typeNum, def){
	var oldStr = $(el).val();
	var newStr = symbol = "";
	var count = oldStr.length;
	var point = 0;
	for (var i = 0; i < count; i++){
		symbol = oldStr.substr(i,1);
		if (typeNum == 'float'){
			if (symbol == ","){ 
				symbol = ".";
			}
			if (symbol == "."){
			  point++;  
			}
			if(point > 1 && symbol == "." && (oldStr.split('.').length-1) > 1){
				symbol = "";
			}
			if(symbol != " " && ((symbol == "." && i != 0) || (symbol == "-" && i == 0) || isNaN(symbol) == false)){
				newStr += symbol;
			}
		}
		else {
			symbol = oldStr.substr(i,1);
			if(symbol!=" " && isNaN(symbol) == false){
				newStr += symbol;
			}
		}
	}
	$(el).val(newStr);
	if(newStr==""){
		$(el).val(def);
	}
}
$(document).ready(function(){
	//------------------------------------- view_left.php handler ------------------------------
	//------------------------------------- Add new tree ---------------------------------------
    $('.tree_row .add a').click(function(){
        tree_append(this);
        return false;
    });
    $('a.append_tree').click(function(){
        tree_append(this);
        return false;
    });
	// view_navigate handler
	$('.item-opt a, .primary').tooltip();
	
	$('.checkbox').live('click',function(){
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
	$('.not-be-sortable a').live('click',function(){
		alert('Нельзя именить позицию товара\n в режиме быстрой сортировки!');
		return false;
	});
	$('.item').live('click',function(){
		window.location=$(this).closest('tr').attr('href');
	});

	$('.check-all img').live('click',function(){
		if($(this).attr('src') == 'img/struct-content-check-active.png'){
			$('.check-all img,.checkbox img').attr('src','img/struct-content-check.png');
			$('.checkbox').find('input').val('0');
		}
		else{
			$('.check-all img,.checkbox img').attr('src','img/struct-content-check-active.png');
			$('.checkbox').find('input').val('1');
		}
	});
	//keyup(pager)
	$(document).keydown(function(eventObject){
		if(eventObject.keyCode == 13){
			return false
		}
	});
	var total_page = $('#tp').val();
	$('.pcount_up, .pcount_down').keyup(function(eventObject){
		if(eventObject.keyCode == 13){
			var page = 0;
			if($(this).val() % 1 !== 0){
				page = $('#np').val();
			} else{
				if($(this).val() * 1 < 1){
					page = 1;
				} else{
					if($(this).val() * 1 > total_page * 1){
						page = total_page;
					}else {
						page = $(this).val();
					}
				}
			}
			if(page == 0 ){page = 1;}
			var url = $('#url').val()+page;
			window.location = url;
		} else return false;
	});
	//-------------------------------- view_item.php -----------------------------------------
	// Tabs handler
	$('#infoTabs li:first').addClass('active');
	$('.tab-content div:first').addClass('active in');
	$('#infoTabs li').live('click',function(){
		$('#infoTabs li').removeClass('active');
		$('.tab-content div').removeClass('active in');
		$(this).addClass('active');
		var id = $(this).find('a').attr('tab');
		$(id).addClass('active');
		setTimeout(function(){$(id).addClass('in');},200);
	});
	// Checkboxes load defaults
	$('.default').each(function(i,el){
		if($(el).attr('value') == '1'){
			$(el).attr('src','img/struct-content-check-active.png');
			$(el).next().val('1');
		} else{
			$(el).attr('src','img/struct-content-check.png');
			$(el).next().val('0');
		}
	});
	$('.default-active').each(function(i,el){
		if($(el).attr('value') == '0'){
			$(el).attr('src','img/struct-content-check.png');
			$(el).next().val('0');
		} else{
			$(el).attr('src','img/struct-content-check-active.png');
			$(el).next().val('1');
		}
	});
	// Checkboxes change state
	$('.check').live('click',function(){
		if($(this).attr('src') == 'img/struct-content-check-active.png'){
			$(this).attr('src','img/struct-content-check.png');
			$(this).next().val('0');
		}
		else {
			$(this).attr('src','img/struct-content-check-active.png');
			$(this).next().val('1');
		}
	});
	// Submit form
	$('#fsave').live('click',function(){
		$('input[type=text]').each(function(i,el){
			$(el).removeAttr('disabled');
		});
		$('form').submit();
	});
	
});
