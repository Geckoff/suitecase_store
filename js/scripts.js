// Serialscroll exclude option bug ?
function serialScrollFixLock(event, targeted, scrolled, items, position){
	serialScrollNbImages = $('#thumbs_list li:visible').length;
	serialScrollNbImagesDisplayed = 4;

	var leftArrow = position == 0 ? true : false;
	var rightArrow = position + serialScrollNbImagesDisplayed >= serialScrollNbImages ? true : false;

	$('a#prev').css('cursor', leftArrow ? 'default' : 'pointer').css('display', leftArrow ? 'none' : 'block').fadeTo(0, leftArrow ? 0 : 1);
	$('a#next').css('cursor', rightArrow ? 'default' : 'pointer').fadeTo(0, rightArrow ? 0 : 1).css('display', rightArrow ? 'none' : 'block');
	return true;
}
// Function verification phone
function verifyPhone(el){
    var tmpPhone = /^([0-9_\-\.\ \(\)\+\;]+)$\.?$/i;
    var result = tmpPhone.test($(el).val())
    if (!result) {return false;}
    else {return true;}
}
$(document).ready(function(){
	// Cart init
	$(document).cart({
		addButton: '.add-to-cart',
		removeButton: '.remove-item',
		incButton: '.quantity-up',
		decButton: '.quantity-down',
		cartUrl: '/cart',
		cartContainer: '.cartContainer',
		prodContainer: '.prodContainer',
		totalCntContainer: '.totalCntContainer',
		totalPriceContainer: '.totalPriceContainer',
		imgPath: '/data/catalog/small/'
	});
	
	$('.btn.disabled').click(function(){
		return false;
	});
	
	// Cart hover 
	$('.cart-block').hover(function(){
		$(this).addClass('hover').addClass('expand').find('.cart-block-content').stop(true,true).slideDown(450);
	},function(){
		var t = $(this);
		t.removeClass('hover').find('.cart-block-content').stop(true,true).delay(450).slideUp(250);
		setTimeout(function(){if(!t.hasClass('hover'))t.removeClass('expand')},700)
	});
	
	// Меню категорий
	if($('.left-col .menu_lvl_0 li.active').size() == 0){
		$('.left-col .menu_lvl_0 li:first ul:first').css('display','block');
	}
	$('.left-col .menu li.active').find('ul:first').css('display','block');
	
	// Scroll to top
	$(window).scroll(function () {
		if ($(this).scrollTop() > 100) {
			$('#back-top').fadeIn();
		} else {
			$('#back-top').fadeOut();
		}
	});
	// scroll body to 0px on click
	$('#back-top a').click(function () {
		$('body,html').stop(false, false).animate({
		scrollTop: 0
		}, 500);
		return false;
	});
	
	// Поиск
	$('#search').click(function(){
		var form = $(this).closest('form');
		if($.trim(form.find('input[type=text]').val()) != ''){
			form.submit();
		}else{
			return false;
		}
	});
	
	// Слайдер
	$('#slider').nivoSlider({
	   effect: 'fade',
       animSpeed: 700,
       pauseTime: 4500
	});
	
	// Красивый select
	$('.toolbar .limiter, .toolbar .sort-by').jqTransform();
	
	//Product view select/change
	if($.cookie('productView')){
		var productView = $.cookie('productView');
		if(productView == 'list'){
			$('.product_view li.product_view_list').addClass('current');
			$('#products').addClass('list');
		} else{
			$('.product_view li.product_view_grid').addClass('current');
			$('#products').addClass('grid');
		}
	} else{
		var productView = 'grid';
		$('.product_view li.product_view_grid').addClass('current');
		$('#products').addClass('grid');
	}
	$('.product_view li').click(function(){
		var	newView = $(this).text();
		if(newView == productView){
			return false;
		} else{
			productView = newView;
			$.cookie('productView',newView,{expires:365,path:"/"});
			if(productView == 'grid'){
				$('.product_view li.product_view_list').removeClass('current');
				$('.product_view li.product_view_grid').addClass('current');
				$('#products').removeClass('list');
				$('#products').addClass('grid');
			} else{
				$('.product_view li.product_view_grid').removeClass('current');
				$('.product_view li.product_view_list').addClass('current');
				$('#products').removeClass('grid');
				$('#products').addClass('list');
			}	
		}
	});
	
	// multizoom
	$('#zoomer').addimagezoom({
		imagevertcenter: true, 
		magvertcenter: true, 
		zoomrange: [3, 7],
		magnifiersize: [306,306],
		cursorshade: true
	});
	
	// scroll
	$('#thumbs_list').serialScroll({
		items:'li',
		prev:'#prev',
		next:'#next',
		axis:'x',
		offset:0,
		start:0,
		stop:true,
		onBefore:serialScrollFixLock,
		duration:700,
		step: 6,
		lazy: true,
		lock: false,
		force:false,
		cycle:false
	});
	$('#thumbs_list').trigger('goto', 1);// SerialScroll Bug on goto 0 ?
	$('#thumbs_list').trigger('goto', 0);
	serialScrollFixLock('', '', '', '', 0);// SerialScroll Bug on goto 0 ?
	
	// social
	if(window.pluso){
		if(typeof window.pluso.start == "function") return;
	}
	if(window.ifpluso==undefined){
		window.ifpluso = 1;
		var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
		s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true;
		s.src = ('https:' == window.location.protocol ? 'https' : 'http')  + '://share.pluso.ru/pluso-like.js';
		var h=d[g]('body')[0];
		h.appendChild(s);
	}
	
	// tabs
	$('.tab-nav a:first').addClass('active');
	$($('.tab-nav a:first').attr('data-tab')).addClass('active');
	
	$('.short-desc .more').click(function(){
		var tab = $('.tab-nav a[name='+$(this).attr('data-tab')+']');
		if(!tab.hasClass('active')){
			$('.tab-nav a.active').removeClass('active');
			$('.tab-content div.active').removeClass('active');
			tab.addClass('active');
			$(tab.attr('data-tab')).addClass('active');
		}
		$('html,body').stop(true, true).animate({
			scrollTop: (tab.offset().top - 100)
		},500);
		return false;
	});
	
	$('.tab-nav a').click(function(){
		if(!$(this).hasClass('active')){
			$('.tab-nav a.active').removeClass('active');
			$('.tab-content div.active').removeClass('active');
			$(this).addClass('active');
			$($(this).attr('data-tab')).addClass('active');
		}
		return false;
	});
	
	// params
	$('.params li a').click(function(){
		var l = $(this).closest('li');
		if(!l.hasClass('expand')){
			l.find('ul').stop(true, true).slideDown(450);
			setTimeout(function(){l.addClass('expand')},450);
		}else{
			l.find('ul').stop(true, true).slideUp(450);
			setTimeout(function(){l.removeClass('expand')}, 450);
		}
		return false;
	});
	
	// feedback
	$('.send').click(function(){
	if(!$(this).hasClass('disabled')){
		var sendflag = true,
			button = $(this),
			form = $(this).closest('form'),
			legend = $(this).closest('form').find('.legend');
			button.blur();
			form.removeClass('success').removeClass('fail').find('.verify input[type=text], .verify textarea').each(function(){
				if($(this).attr('name') == 'phone' && !verifyPhone($(this))){
					sendflag = false;
					$(this).closest('.verify').addClass('iserr');
				}else if($.trim($(this).val()) == ''){
					sendflag = false;
					$(this).closest('.verify').addClass('iserr');
				}else {
					$(this).closest('.verify').removeClass('iserr');
				}
			});
			if(sendflag == true){
				button.addClass('disabled').prop('disabled', true);
				form.addClass('loading');
				legend.html('Отправка сообщения...');
				$.ajax({
					url: "/ajax.php",
					data: 'processor='+button.attr('data-handler')+'&'+form.serialize(),
					type: "POST",
					error: function(error) {
						error.err = 1;
						error.msg = '<span class="red">Что-то пошло не так... Обновите страницу и попробуйте снова!</span>';
						setTimeout(function(){
							form.removeClass('loading').addClass('fail');
							legend.html(error.msg);
							button.removeClass('disabled').prop('disabled', false).blur();
						}, 1500);
					},
					success: function(result) {
						result = $.parseJSON(result);
						if(result.err == 0){
							setTimeout(function(){
								if(result.clear == 1){
									$(document).cart('clear');
								}
								form.removeClass('loading').addClass('success').find('textarea').val('');
								legend.html(result.msg);
								button.removeClass('disabled').prop('disabled', false).blur();
							}, 1500);
						}else {
							setTimeout(function(){
								form.removeClass('loading').addClass('fail');
								legend.html(result.msg);
								button.removeClass('disabled').prop('disabled', false).blur();
							}, 1500);
						}
					}
				});
			}
			return false;
		}else{
			return false;
		}
	});
	
	// Убираем нижнюю границу у последнего блока новостей на странице
	$('.news-block:last').css('border-bottom','none');
	
	// Tooltip
	$('.bs-tooltip').tooltip({placement: 'top'});
});
