<?php
	if (!isset($_COOKIE['modal'])) {
		
		setcookie('modal','opened',time()+60*60*24*7*30, '/');
	}
	if (!isset($_COOKIE['pages_quant'])) {
		
		setcookie('pages_quant','1',time()+60*60*24*7*30, '/');
	}
	elseif ($_COOKIE['pages_quant'] < 7) {
		$kuka = $_COOKIE['pages_quant'] + 1;
		setcookie('pages_quant',$kuka,time()+60*60*24*7*30, '/');	
	}
	//echo $_COOKIE['pages_quant'];
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    <meta http-equiv="title" content="<?php if(isset($META['meta_title']) && !empty($META['meta_title'])) echo htmlspecialchars($META['meta_title']); else echo htmlspecialchars($TITLE); ?>" />
    <meta http-equiv="keywords" content="<?php if(isset($META['meta_keywords']) && !empty($META['meta_keywords'])) echo htmlspecialchars($META['meta_keywords']); else echo htmlspecialchars($TITLE); ?>" />
    <meta http-equiv="description" content="<?php if(isset($META['meta_description']) && !empty($META['meta_description'])) echo htmlspecialchars($META['meta_description']); else echo htmlspecialchars($TITLE); ?>" />
    <meta name="author" content="Фабрика проектов" />
    <meta name="copyright" content="Фабрика проектов ©" /> 
    <meta http-equiv="reply-to" content="info@fpro.by" />
    <meta name='yandex-verification' content='58a0b97c2b1e78a6' />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php if(isset($META['meta_title']) && !empty($META['meta_title'])) echo $META['meta_title']; else echo $TITLE; ?></title>
	<base  href="<?php echo $ClientConfig["HOST"]; ?>" />

	<link rel="icon" type="image/vnd.microsoft.icon" href="/favicon.ico" />
	<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="/css/themes/default/default.css" media="all" /> 
	<link rel="stylesheet" type="text/css" href="/css/nivo-slider.css" media="all" />
	<link rel="stylesheet" type="text/css" href="/css/multizoom.css" media="all" />
	<link rel="stylesheet" type="text/css" href="/css/cart.css" media="all" />
	<link rel="stylesheet" type="text/css" href="/js/jquery.mmenu/jquery.mmenu.css" media="all" />
	<link rel="stylesheet" type="text/css" href="/js/jquery.mmenu/extensions/positioning/jquery.mmenu.positioning.css" media="all" />
	<link rel="stylesheet" type="text/css" href="/css/style.css?v=1.2" media="all" />
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script type="text/javascript" src="//vk.com/js/api/openapi.js?116"></script>
    <script type="text/javascript">
        if (typeof jQuery == 'undefined') {
            document.write(unescape("%3Cscript src='/js/jquery-1.9.0.min.js' type='text/javascript'%3E%3C/script%3E"));
        }
    </script>
    <script>
		$(document).ready(function(){
			var limit = "<?php if(isset($_SESSION['limit'])) echo $_SESSION['limit']; else echo $ClientConfig['count_per_page']; ?>";
			var orderby = "<?php if(isset($_SESSION['orderby'])) echo $_SESSION['orderby']; else echo $ClientConfig['orderby']; ?>";
			$('.limiter').find('option').each(function(i, el){
					if($(el).attr('cnt') == limit){
						$(el).attr('selected', 'selected');
					}
			});
			$('.sort-by').find('option').each(function(i, el){
					if($(el).attr('sort') == orderby){
						$(el).attr('selected', 'selected');
					}
			});
		});
	</script>
    <script>
		$(document).ready(function(){
			var curstr = document.location.href;
            if (curstr.indexOf("sportivnye-sumki") != -1 || curstr.indexOf("ryukzaki-sportivnye-i-gorodskie") != -1) {
                $("#fixed-block").attr("href", "http://1bags.by/discounts/vyberi-luchshii-podarok-1-iz-2---k-ryukzakam-i-sportivnym-sumkam");
            }
		});
	</script>
    <script type="text/javascript" src="/js/jqtransform.js"></script> 
    <script type="text/javascript" src="/js/jquery.nivo.slider.pack.js"></script> 
    <script type="text/javascript" src="/js/multizoom.js"></script> 
    <script type="text/javascript" src="/js/jquery.scrollto.js"></script> 
    <script type="text/javascript" src="/js/jquery.serialscroll.js"></script> 
    <script type="text/javascript" src="/js/bootstrap-tooltip.js"></script> 
    <script type="text/javascript" src="/js/jquery.cookie.js"></script>
    <script type="text/javascript" src="/js/jquery.json-2.4.min.js"></script> 
    <script type="text/javascript" src="/js/cart.js?v=1.2"></script> 
    <script type="text/javascript" src="/js/jquery.mmenu/jquery.mmenu.js?v=1.2"></script> 
    <script type="text/javascript" src="/js/scripts.js?v=1.2"></script> 
    <!--[if lt IE 9]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <script type="text/javascript" src="/js/PIE_IE678.js"></script>      
        <script type="text/javascript" src="/js/jquery.placeholder.1.3.min.js"></script>
        <script>
			$('document').ready(function(){
				$('li:last-child').css('border-bottom','none');
				$.Placeholder.init();
			});
		</script>
		<style>
			.clear {
				height: 1px;
			}
		</style>
    <![endif]-->
    <!--[if IE 9]>
	  <script type="text/javascript" src="js/PIE_IE9.js"></script>
	<![endif]-->
	<?php if ($TITLE == 'Акция! Интернет-магазин рюкзаков, сумок, чемоданов 1bags дарит подарки каждому покупателю!'): ?>
	<meta property='og:title' content=' Интернет-магазин рюкзаков, сумок, чемоданов 1bags.by дарит подарок каждому покупателю!' />
	<meta property='og:image' content='https://1bags.by/images/oblozhka-inside.jpg' />
	<meta property='og:description' content='1bags.by - это стильные и надежные чемоданы, рюкзаки, кошельки, спортивные, мужские и дорожные сумки. Каждый наш клиент получает бесплатный подарок! Не верите? Заходите и проверяйте!' />
	<?php else: ?>
	<meta property='og:title' content='<?=$ClientConfig['og-title'] ?>' />
	<meta property='og:image' content='<?=$ClientConfig['og-image'] ?>' />
	<meta property='og:description' content='<?=$ClientConfig['og-description'] ?>' />
	<?php endif; ?>
</head>
