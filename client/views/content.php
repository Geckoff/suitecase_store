<body>
<div class="mobile-nav">
	<div class="mobile-nav-block">
		<a style="display: block" href="#product-menu" id="nav-icon3" class="ham-icon-items">
			<span></span>
			<span></span>
			<span></span>
			<span></span>
		</a>	
		<a href="#product-menu">Товары</a>
	</div>
	<div class="mobile-nav-block">
		<a href="#main-menu">Меню</a>
		<a style="display: block" href="#main-menu" id="nav-icon4" class="ham-icon-main">
			<span></span>
			<span></span>
			<span></span>
		</a>	
	</div>	
</div>
<div class="mobile-menu">
	<nav id="main-menu">
		<?=$tMenubuf?>
	</nav>
	<nav id="product-menu">
		<?php $vari = false?>
		<?php echo buildNavMenu($_catalog_url, $TABLE['catalog_tree'], $ClientConfig['catalog_root'], 'mob_menu') ?>
	</nav>
</div>
<!--
    <div>
        <a id="fixed-block2" href="#" target="_blank"></a>
    </div>
-->
    <?php
        if (isset($FIXED_BLOCK[0])) {
                echo $FIXED_BLOCK[0]['content'];
        }
    ?>
	<div id="wrapper" class="clearfix">
		<p style="display: none;" id="back-top"><a href="javascript: void(0)"><span></span></a></p>
		<div class="header-container clearfix">
			<div class="header">
                <?php
                    if (isset($TOP_BLOCK[0])) {
                            echo $TOP_BLOCK[0]['content'];
                    }
                ?>
				<a class="logo" href="<?=$ClientConfig['HOST']?>" title="<?=$ClientConfig['HOST']?>"><?=$ClientConfig['HOST']?></a>
                <!--<div class="pluso-header">
                    <script type="text/javascript">(function() {
  if (window.pluso)if (typeof window.pluso.start == "function") return;
  if (window.ifpluso==undefined) { window.ifpluso = 1;
    var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
    s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true;
    s.src = ('https:' == window.location.protocol ? 'https' : 'http')  + '://share.pluso.ru/pluso-like.js';
    var h=d[g]('body')[0];
    h.appendChild(s);
  }})();</script>
<div class="pluso" data-background="transparent" data-options="medium,square,line,horizontal,counter,theme=04" data-services="vkontakte,odnoklassniki,facebook,twitter,google" data-url="http://1bags.by/discounts/akciya-1bags-darit-podarki-kazhdomu-pokupatelyu" data-title="Интернет-магазин 1bags.by - это это стильные и надежные чемоданы, рюкзаки, кошельки, спортивные, мужские и дорожные сумки. " data-description="Каждый покупатель в нашем интернет-магазине особенный, потому что каждый обязательно получает бесплатный подарок от 1bags, а в нагрузку к подарку может получить и скидку! Подробнее - в нашем разделе &quot;Акции&quot;." data-user="833759409"></div>
                </div>    -->
                <form class="searchbox" method="get" action="<?=$_catalog_url?>">
					<span>Поиск</span>
					<input type="text" name="q" value="" placeholder="Поиск" />
					<button id="search">Ok</button>
				</form>
				<div class="phone">+375 29 743 62 22 <br />+375 29 394 62 22</div>
                <span>Бесплатная доставка по Минску и Беларуси</span>
			</div>
			<div class="nav" >
				<?=$tMenubuf?>
				<div class="cart-block">
					<a href="<?=$_cart_url?>" title="Перейти в корзину">Корзина: <span class="totalCntContainer"></span></a>
					<div class="cart-block-content">
						<table class="prodContainer">
							<tbody>
							</tbody>
						</table>
						<span>Всего: <strong class="totalPriceContainer"></strong></span>
						<a class="btn" href="<?=$_cart_url?>#order" title="Перейти в корзину">Оформить заказ</a>
					</div>
				</div>
			</div>
		</div>
		<div class="columns clearfix">
			<div class="left-col">
				<div class="block">
					<h3 class="block-title">Категории</h3>
					<div class="block-content menu">
						<?=buildNavMenu($_catalog_url, $TABLE['catalog_tree'], $ClientConfig['catalog_root'])?>
					</div>
				</div>
				<?php
					/*
					if(count($ADDRESSES) > 0 ){
						echo'<div class="block"><h3 class="block-title">Наши контакты</h3><div class="block-content contacts">';
						for($i = 0, $cnt = count($ADDRESSES); $i < $cnt; $i++){
							if($i == $cnt - 1){
								$class = 'class="last"';
							} else $class = '';
							echo '<dl '.$class.'><dt><h6>'.$ADDRESSES[$i]['title'].':</h6></dt>';
							for($j = 0, $cntEl = count($ADDRESSES[$i]['elements']); $j < $cntEl; $j++){
								echo '<dd>'.$ADDRESSES[$i]['elements'][$j]['value'].'</dd>';
							}
							echo '</dl>';
						}
						echo '</div></div>';
					}
					*/
				?>
                    <div class="block">
                        <!-- VK Widget -->
                        <div id="vk_groups"></div>
                        <script type="text/javascript">
                        VK.Widgets.Group("vk_groups", {mode: 0, width: "230", height: "320", color1: 'FFFFFF', color2: '2B587A', color3: '5B7FA6'}, 90411326);
                        </script>
                    </div>
					<div class="block"><h3 class="block-title">Режим работы</h3><div class="block-content mode">
					<ol>
						<li>Пн</li>
						<li>Вт</li>
						<li>Ср</li>
						<li>Чт</li>
						<li>Пт</li>
						<li>Сб</li>
						<li>Вс</li>
					</ol>
					<span>9:00 - 20:00</span>
					<?php
					if(count($_mobile_list) > 0){
						echo '<ul>';
						foreach($_mobile_list as $mobile){
							if(isset($mobile['name']) && !empty($mobile['name'])){
								switch($mobile['name']){
									case 'velcom': $img = '/img/velcom.png';
											break;
									case 'mts': $img = '/img/mts.png';
											break;
									case 'life': $img = '/img/life.png';
											break;
									default: $img = '';
											break;
								}
								echo '<li style="background-image: url(\''.$img.'\');">'.$mobile['value'].'</li>';
							}
						}
						echo '</ul>';
					}
					echo '</div></div>';
                    if (isset($LEFT_BLOCK[0])) {
                            echo $LEFT_BLOCK[0]['content'];    
                    }
					echo $specialBuf;
				?>
			</div>
			<div class="right-col">
				<?=$CONTENT?>
			</div>
		</div>
		<div class="hFooter"></div>
	</div>
	<div id="footer" class="clearfix">
		<div class="footer-block">
            <p class="zag">Каталог</p>
            <ul>
                <li><a href="/katalog/chemodany-na-2-kolesah-1">Чемоданы на 2 колесах</a></li>
                <li><a href="/katalog/chemodany-na-4-kolesah-1">Чемоданы на 4 колесах</a></li>
                <li><a href="/katalog/dorozhnye-sumki-2">Дорожные сумки</a></li>
                <li><a href="/katalog/sportivnye-sumki">Спортивные сумки</a></li>
                <li><a href="/katalog/ryukzaki-sportivnye-i-gorodskie">Рюкзаки</a></li>
            </ul>
        </div>
		<div class="footer-block">
            <p class="zag">&nbsp;</p>
            <ul>
                <li><a href="/kozhanye-muzhskie-sumki-v-minske">Мужские сумки</a></li>
                <li><a href="/muzhskie-kozhanye-portmone-i-koshelki-v-minske">Мужские портмоне</a></li>
                <li><a href="/katalog/zazhimy-dlya-deneg-1">Зажимы для денег</a></li>
                <li><a href="/katalog/oblozhki-dlya-dokumentov-1">Обложки</a></li>

            </ul>
        </div>
		<div class="footer-block short-footer-block">
            <p class="zag">Клиенту</p>
            <ul>
                <li><a href="/discounts">Акции и скидки</a></li>
                <li><a href="/dostavka">Доставка по РБ</a></li>
                <li><a href="/o-nas">О нас</a></li>
                <li><a href="/reviews">Отзывы и вопросы</a></li>
                <li><a href="/kontakty">Контакты</a></li>
            </ul>
        </div>
		<div class="footer-block">
            <div><span>Время работы оператора: 9.00 - 20.00</span></div>
            <div><span>Заказы через корзину: круглосуточно</span></div>
            <div class="phone"><span>+375 29 743 62 22</span></div>
            <div class="phone"><span>+375 29 394 62 22</span></div>
            <div class="owner">ИП Лавенецкий Андрей Владимирович, г. Могилев, ул. Фатина д. 6, кв. 192<br>Св-во №790693744 выдано администрацией Октябрьского района г. Могилева 7.05.2010<br>Публикация в торговом реестре: 31.01.2015</div>
        </div>
	</div>
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter24243322 = new Ya.Metrika({id:24243322,
                        webvisor:true,
                        clickmap:true,
                        trackLinks:true,
                        accurateTrackBounce:true});
            } catch(e) { }
        });
    
        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";
    
        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
    </script>
    <noscript><div><img src="//mc.yandex.ru/watch/24243322" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
    
      ga('create', 'UA-48821888-1', '1bags.by');
      ga('send', 'pageview');
    </script>
    <script type="text/javascript">
        cackle_widget = window.cackle_widget || [];
        cackle_widget.push({widget: 'Comment', id: 30913});
        (function() {
            var mc = document.createElement('script');
            mc.type = 'text/javascript';
            mc.async = true;
            mc.src = ('https:' == document.location.protocol ? 'https' : 'http') + '://cackle.me/widget.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(mc, s.nextSibling);
        })();
    </script>
    <link href="https://clients.streamwood.ru/StreamWood/sw.css" rel="stylesheet" type="text/css" />
<!-- BEGIN JIVOSITE CODE {literal} -->
<script type='text/javascript'>
(function(){ var widget_id = 'OFQ5DAOEJu';
var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);})();</script>
<!-- {/literal} END JIVOSITE CODE -->
<script type="text/javascript">(window.Image ? (new Image()) : document.createElement('img')).src = location.protocol + '//vk.com/rtrg?r=KcaqMWniQh0ynLtcJ*4rK4dv9x/VGnKDY1LTcTvHxsXE*SgP9GTRch8jDoNOtxMOEwkOrSRBB7apC62DBCYjiT79RLUF/9DuqQj0eTbULGXMSUJ44q0m3zzePbCvH9osd9G/hD3hdwJvJXZcw0oBcLRuxEvQCnwff6KWQxl81DA-';</script>
<script type="text/javascript">
$(document).ready(function() {
	$("#product-menu").mmenu({
		navbar: {
	        title: "Категории товаров"
	    },
	    offCanvas: {
	       position  : "left",
	    }
	});
	$("#main-menu").mmenu({
		navbar: {
	        title: "Меню"
	    },
		offCanvas: {
		   position  : "right",
		}
	});
	
	var apiProducts = $("#product-menu").data( "mmenu" );
	
	apiProducts.bind( "open:start", function() {
		$('.ham-icon-items').addClass('open');
	});
	
	apiProducts.bind( "close:start", function() {
		$('.ham-icon-items').removeClass('open');
	});
	
	var apiMain = $("#main-menu").data( "mmenu" );
	
	apiMain.bind( "open:start", function() {
		$('.ham-icon-main').addClass('open');
	});
	
	apiMain.bind( "close:start", function() {
		$('.ham-icon-main').removeClass('open');
	});
});
</script>

</body>
</html>