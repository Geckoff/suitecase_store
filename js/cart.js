(function($){
	var defaults = {
		addButton: null,					// Селектор кнопки "добавить в корзину"
		removeButton: null,					// Селектор кнопки "удалить товар из корзины"
		incButton: null,					// Селектор кнопки "увеличить количество"
		decButton: null,					// Селектор кнопки "уменьшить количество"
		prodContainer: null,				// Конейнер модального блока товаров 
		cartContainer: null,				// Конейнер блока товаров на странице "Корзина" 
		totalCntContainer: null,			// Контейнер блока общего количества товаров
		totalPriceContainer: null,			// Контейнер блока общей цены товаров
		cartUrl: '/cart',					// Url корзины
		ajUrl: '/ajax-cart.php',			// URL ajax-обработчика (получает инфу для модального блока)
		ajError: null,						// Обработчик ошибки ajax
		ajSuccess: null,					// Обработчик успеха ajax
		show: true,							// Показывать всплывающие сообщения
		imgPath: null,						// Путь к папке изображений
		autoDestroy: true,					// Автоматически уничтожать всплывающие сообщения 
		hoverDestroy: false,				// Уничтожать сообщения после hover() 
		intime: 250,						// Время появления сообщения
		outtime: 450,						// Время исчезновения сообщения
		delay: 2500,						// Время жизни сообщения
	},
	cntPopup = 0,
	settings = {},
	cartCookie = [],
	plural_type = function(n){
		return (n%10==1 && n%100!=11 ? 0 : (n%10>=2 && n%10<=4 && (n%100<10 || n%100>=20) ? 1 : 2));
	},
	number_format = function(number,decimals,dec_point,thousands_sep){
		var i, j, kw, kd, km;
		if( isNaN(decimals = Math.abs(decimals))){
			decimals = 2;
		}
		if( dec_point == undefined ){
			dec_point = ",";
		}
		if( thousands_sep == undefined ){
			thousands_sep = ".";
		}
		i = parseInt(number = (+number || 0).toFixed(decimals)) + "";
		if( (j = i.length) > 3 ){
			j = j % 3;
		}else{
			j = 0;
		}
		km = (j ? i.substr(0, j) + thousands_sep : "");
		kw = i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands_sep);
		kd = (decimals ? dec_point + Math.abs(number - i).toFixed(decimals).replace(/-/, 0).slice(2) : "");
		return km + kw + kd;
	},
	check_number = function(el, typeNum, def){
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
			}else {
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
	},
	changeQuantity = function(pid,itemData,newVal){
		for(var i in cartCookie){
			if(cartCookie[i].pid == pid){
				cartCookie[i].cnt = newVal;
				$.cookie('cart',$.toJSON(cartCookie),{expires:7,path:"/"});
				$(settings.prodContainer).find('tr[data-product-id='+pid+']').data('cart',{pid:itemData.pid,cnt: newVal,title: itemData.title,price: itemData.price,url: itemData.url,fname: itemData.fname});
				$(settings.prodContainer).find('tr[data-product-id='+pid+'] .count').text(newVal+'x');
				$(settings.prodContainer).find('tr[data-product-id='+pid+'] .price').text(number_format(itemData.price * newVal,0,"."," ")+' руб');
				$(settings.cartContainer).find('tr[data-product-id='+pid+'] input').val(newVal);
				$(settings.cartContainer).find('tr[data-product-id='+pid+'] .summary').text(number_format(itemData.price * newVal,0,"."," ")+' руб');
				handler.checkCart($(settings.prodContainer),$(settings.totalCntContainer),$(settings.totalPriceContainer));
				break;
			}
		}
	},
	handler = {
		init: function(options){
			settings = $.extend(defaults,options);
			$('body').append('<div id="cartPopup" class=""/>');
			if($.cookie('cart')){
				handler.getInfo('cart='+$.cookie('cart'), false);
				cartCookie = $.parseJSON($.cookie('cart'));
				for(var i in cartCookie){
					$(settings.addButton+'[data-product-id='+cartCookie[i].pid+']').addClass('in-cart').addClass('disabled').attr('title', 'В корзине').html('В корзине<span class="add"></span>');
				}
			}else {
				handler.getInfo('cart=[]', false);
			}
			$(settings.addButton).cart('addInit');
		},
		checkCart : function(pc,tcc,tpc){
			var totalCnt = totalPrice = 0,
				text = '', text_arr = ['товар', 'товара', 'товаров'];
			tcc.text('').addClass('loading');
			tpc.text('').addClass('loading');
			pc.first().find('tr').each(function(){
				var d = $(this).data('cart');
				totalCnt = totalCnt + d.cnt * 1;
				totalPrice = totalPrice + d.price * d.cnt;
			});
			if(totalCnt > 0){
				tcc.removeClass('loading').html(totalCnt+' <span>'+text_arr[plural_type(totalCnt)]+'</span>');
			}else{
				tcc.removeClass('loading').html('<span class="cart-is-empty">(Пусто)</span>');
			}
			tpc.removeClass('loading').text(number_format(totalPrice,0,"."," ")+' руб');
			if ($('#shipping_price').length > 0) {
				var shipPrice = 5;
				if (totalPrice > 149) {
					var shipPrice = 0; 
					$('#ems_ship_price').text('Бесплатно');
				}	 
				else {
					$('#ems_ship_price').text(shipPrice + ' руб.');	
				}
				$('#shipping_price').val(shipPrice);
				$('#total_price').val(totalPrice);
			}
			return false;
		},
		getInfo : function(formdata,sm){
			$.ajax({
				url: settings.ajUrl,
				data: formdata,
				type: "POST",
				error: settings.ajError? settings.ajError : function(error){return false},
				success: settings.ajSuccess? settings.ajSuccess : function(result){
					result = $.parseJSON(result);
					for(var i in result){
						$(settings.prodContainer).append('<tr data-product-id="'+result[i].pid+'"><td class="count">'+result[i].cnt+'x</td><td class="title"><a href="'+result[i].url+'" target="_blank">'+result[i].title+'</a></td><td class="price">'+number_format(result[i].price * result[i].cnt,0,"."," ")+' руб</td><td class="delete"><i class="remove-item" data-product-id="'+result[i].pid+'"></i></td></tr>');
						$(settings.prodContainer).find('tr:last').data('cart',{pid:result[i].pid,cnt: result[i].cnt,title: result[i].title,price: result[i].price,url: result[i].url,fname: result[i].fname});
						if($(settings.cartContainer).size() > 0){
							$(settings.cartContainer).append('<tr data-product-id="'+result[i].pid+'"><td class="img"><img src="'+settings.imgPath+result[i].fname+'" /></td><td class="title"><a href="'+result[i].url+'" target="_blank">'+result[i].title+'</a></td><td class="price">'+number_format(result[i].price,0,"."," ")+' руб</td><td class="count"><div class="quantity"><a class="quantity-up" data-product-id="'+result[i].pid+'"></a><input type="text" name="product['+result[i].pid+']" value="'+result[i].cnt+'" data-product-id="'+result[i].pid+'" /><a class="quantity-down" data-product-id="'+result[i].pid+'"></a></div><a class="remove-item" data-product-id="'+result[i].pid+'"></a></td><td class="summary">'+number_format(result[i].price * result[i].cnt,0,"."," ")+' руб</td></tr>');
							$(settings.cartContainer).find('tr:last input').cart('inputInit');
						}
						if(sm){
							handler.showMessage('<h6>Добавление товара</h6><a class="img" href="'+result[i].url+'" target="_blank" style="background-image:url(\''+settings.imgPath+result[i].fname+'\')"></a><p><a href="'+result[i].url+'" target="_blank">'+result[i].title+'</a><br/>добавлен в корзину</p>');
						}
					}
					$(settings.removeButton).cart('delInit');
					$(settings.incButton).cart('incInit');
					$(settings.decButton).cart('decInit');
					handler.checkCart($(settings.prodContainer),$(settings.totalCntContainer),$(settings.totalPriceContainer));
					return false;
				}
			});
		},
		showMessage : function(message){
			var popup = $('#cartPopup').clone().appendTo('body').addClass('cart-popup').attr('id','popup_'+cntPopup);
			popup.css({'display':'block','top':$(window).height() + popup.outerHeight(true)}).html(message).append('<a class="close-popup"></a>');
			popup.prevAll('.cart-popup').each(function(){
				var o = $(this).position().top - popup.outerHeight(true);
				$(this).css({'top': o }); 
			});
			var top = $(window).height() - popup.outerHeight(true);
			popup.animate({'top':top},settings.intime).find('.close-popup').bind('click.cart', function(){handler.destroyMessage(popup,0)});
			if(settings.hoverDestroy) popup.bind('mouseleave.cart', function(){handler.destroyMessage(popup,settings.delay)});
			if(settings.autoDestroy) handler.destroyMessage(popup,settings.delay);
			cntPopup++;
			return false;
		},
		destroyMessage : function(popup, delay){
			popup.delay(delay).fadeOut(settings.outtime);
			setTimeout(function(){
				popup.prevAll('.cart-popup').each(function(){
					var o = $(this).position().top + popup.outerHeight(true);
					$(this).css({'top': o }); 
				});
				popup.remove();
			},delay + settings.outtime);
			return false;
		},
		addInit : function(){
			return this.each(function(){
				var data = $(this).data('cart');
				if(!data){
					if($(this).hasClass('in-cart')){
						$(this).data('cart',false);
					}else{
						$(this).data('cart',true);
					}
					$(this).bind('click.cart',handler.add);
				}	
			});			
		},
		delInit : function(){
			return this.each(function(){
				var data = $(this).data('cart');
				if(!data){
					$(this).data('cart',true);
					$(this).bind('click.cart',handler.del);
				}
			});
		},
		inputInit : function(){
			return this.each(function(){
				var data = $(this).data('cart');
				if(!data){
					$(this).data('cart',true);
					$(this).keyup(function(){check_number($(this),'int','')}).change(function(){check_number($(this),'int','1');}).bind('change.cart',handler.setQuantity);
				}
			});
		},
		incInit : function(){
			return this.each(function(){
				var data = $(this).data('cart');
				if(!data){
					$(this).data('cart',true);
					$(this).bind('click.cart',handler.incQuantity);
				}
			});
		},
		decInit : function(){
			return this.each(function(){
				var data = $(this).data('cart');
				if(!data){
					$(this).data('cart',true);
					$(this).bind('click.cart',handler.decQuantity);
				}
			});
		},
		add : function(){
			var t = $(this),
				data = t.data('cart');
			if(!data || data == 'false'){
				handler.showMessage('Этот товар уже в <a href="'+settings.cartUrl+'" target="_blank">корзине</a>');
			}else{
				$(settings.addButton+'[data-product-id='+t.attr('data-product-id')+']').data('cart',false).addClass('in-cart').addClass('disabled').attr('title', 'В корзине').html('В корзине<span class="add"></span>');
				cartCookie.push({pid:t.attr('data-product-id'),cnt:1});
				handler.getInfo('cart='+$.toJSON([{pid:t.attr('data-product-id'),cnt:1}]), settings.show);
				$.cookie('cart',$.toJSON(cartCookie),{expires:7,path:"/"});
			}
			t.blur();
			return false;
		},
		del : function(){
			var pid = $(this).attr('data-product-id'),
				data = $(this).data('cart'),
				itemData = $(settings.prodContainer).find('tr[data-product-id='+pid+']').data('cart');
			for(var i in cartCookie){
				if(cartCookie[i].pid == pid){
					cartCookie.splice(i,1);
					$.cookie('cart',$.toJSON(cartCookie),{expires:7,path:"/"});
					$(settings.removeButton+'[data-product-id='+pid+']').unbind('.cart').removeData('cart');
					$(settings.prodContainer).find('tr[data-product-id='+pid+']').data('cart','').remove();
					if($(settings.cartContainer).size() > 0){
						$(settings.incButton+'[data-product-id='+pid+']').unbind('.cart').removeData('cart');
						$(settings.decButton+'[data-product-id='+pid+']').unbind('.cart').removeData('cart');
						$(settings.cartContainer).find('tr[data-product-id='+pid+']').remove();
					}
					$(settings.addButton+'[data-product-id='+pid+']').data('cart',true).removeClass('disabled').removeClass('in-cart').html('Купить<span class="add"></span>');
					handler.checkCart($(settings.prodContainer),$(settings.totalCntContainer),$(settings.totalPriceContainer));
					if(settings.show){
						handler.showMessage('<h6>Удаление товара</h6><a class="img" href="'+itemData.url+'" target="_blank" style="background-image:url(\''+settings.imgPath+itemData.fname+'\')"></a><p><a href="'+itemData.url+'" target="_blank">'+itemData.title+'</a><br/>удален из корзины</p>');
					}
					break;
				}
			}
			return false;
		},
		incQuantity : function(){
			var pid = $(this).attr('data-product-id'),
				itemData = $(settings.prodContainer).find('tr[data-product-id='+pid+']').data('cart'),
				newVal = $(settings.cartContainer).find('tr[data-product-id='+pid+'] input').val() * 1 + 1 * 1;
			if($.isNumeric(newVal) && newVal < 1000){
				changeQuantity(pid,itemData,newVal);
			}
			return false;
		},
		decQuantity : function(){
			var pid = $(this).attr('data-product-id'),
				itemData = $(settings.prodContainer).find('tr[data-product-id='+pid+']').data('cart'),
				newVal = $(settings.cartContainer).find('tr[data-product-id='+pid+'] input').val() * 1 - 1 * 1;
			if($.isNumeric(newVal) && newVal > 0){
				changeQuantity(pid,itemData,newVal);
			}
			return false;
		},
		setQuantity : function(){
			var pid = $(this).attr('data-product-id'),
				itemData = $(settings.prodContainer).find('tr[data-product-id='+pid+']').data('cart'),
				newVal = $(this).val();
			if($.isNumeric(newVal) && newVal > 0 && newVal < 1000){
				changeQuantity(pid,itemData,newVal);
			}else {
				changeQuantity(pid,itemData,1);
			}
			return false;
		},
		clear : function(){
			$.cookie('cart','');
			$.removeCookie('cart');
			cartCookie = [];
			$(settings.removeButton).unbind('.cart').removeData('cart');
			$(settings.prodContainer).html('');
			$(settings.cartContainer).html('');
			handler.checkCart($(settings.prodContainer),$(settings.totalCntContainer),$(settings.totalPriceContainer));
			$(settings.addButton).data('cart',true).removeClass('disabled').removeClass('in-cart').html('Купить<span class="add"></span>');
			handler.showMessage('Спасибо за заказ! Наш консультант свяжется с вами в ближайшее время!');
			return false;
		}
	};
	
	$.fn.cart = function(action){
		if (handler[action]){
			return handler[action].apply( this, Array.prototype.slice.call(arguments,1));
		}else if(typeof action === 'object' || ! action){
			return handler.init.apply( this, arguments );
		} else {
			$.error( 'Метод с именем ' +  action + ' не существует для jQuery.cart' );
		}
	};
})( jQuery );
