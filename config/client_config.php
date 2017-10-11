<?php
    // Глобальные настройки CLIENT
    
    // PRECONFIG ---------------------------------------------
    $_ROOT = dirname(__FILE__).'/..';
    $_CMS_ENTER = 'login';

    // CLIENT CONFIG -----------------------------------------
    $ClientConfig = array(
        'ROOT' => $_ROOT,
    	'HOST' => 'http://'.$_SERVER['HTTP_HOST'],
    	'DATA_URL' => 'http://'.$_SERVER['HTTP_HOST'].'/data',
    	'DATA_ROOT' => $_ROOT.'/data',
    	'DEBUG' => true,
    	'PROFILER' => false,
        'TIMEZONE' => 'Europe/Minsk',
		'404_TITLE'=>'Страница не найдена (404-я ошибка)',
    	'404_TEXT'=>'<div class="advice">
						<dl>
							<dt>Запрашиваемая Вами страница не найдена, и мы догадываемся почему.</dt>
							<dd>
								<ul class="disc">
									<li>Если Вы набрали URL напрямую, пожалуйста, убедитесь, что не было опечаток.</li>
									<li>Если Вы нажали на ссылку, чтобы перейти сюда, ссылка устарела.</li>
								</ul>
							</dd>
						</dl>
						<dl>
							<dt>Что Вы можете сделать?</dt>
							<dd>
								<ul class="disc">
									<li>Перейдите на <a href="http://'.$_SERVER['HTTP_HOST'].'" title="Вернуться на главную">главную страницу</a>.</li>
									<li>Воспользуйтесь навигацией сайта, чтобы найти желаемую страницу.</li>
								</ul>
							</dd>
						</dl>
					</div>',
    	'404_META_TITLE'=>'Страница не найдена (404-я ошибка)',
        
        // PAGES
        'page_main' => '1',			// ID главной страницы
        'page_catalog' => '2',		// ID страницы, связанной с модулем "Каталог"
        'page_contacts' => '5',
        'page_cart' => '6',
        'page_news' => '2',		// ID страницы, связанной с модулем "Новости"
        'page_reviews' => '9',		// ID страницы Отзывы
        
        
        // MODULES ROOT PARTITION
        'catalog_root' => '0',		// ID корневого раздела модуля "Каталог"
        'news_root' => '0',		// ID корневого раздела модуля "Новости"
        
        // OTHER
        'menu' => '1',				// ID главного меню
        'slider' => '1',
        'mobile' => '1',
        'left_block' => '2',
        'fixed_block' => '3',
        'top_block' => '4',
        'contacts_block' => '5',
        'count_per_page' => '15',	// Количество элементов на странице ( Пока что во всех модулях )
        'orderby' => 'default',
        
    );
    
    // TABLE CONFIG -----------------------------------------
    $TABLE = array(
		'blocks' => 'blocks',
		
		'catalog_orders' => 'catalog_orders',
		'catalog_orders_products' => 'catalog_orders_products',
		
		'catalog_img' => 'catalog_img',
		'catalog_item' => 'catalog_item',
		'catalog_item_parameters' => 'catalog_item_parameters',
		'catalog_parameters' => 'catalog_parameters',
		'catalog_tree' => 'catalog_tree',
		
		'files_tree' => 'files_tree',
		'files_item' => 'files_item',
		
		'gallery_tree' => 'gallery_tree',
		'gallery_item' => 'gallery_item',
		'gallery_img' => 'gallery_img',
		
		'news_tree' => 'news_tree',
		'news_item' => 'news_item',
		'news_img' => 'news_img',
		
		'ip_ban' => 'ip_ban',
		'menu' => 'menu',
		'menu_item' => 'menu_item',
		'modules' => 'modules',
		'reviews' => 'reviews',
		'settings' => 'settings',
		'settings_element' => 'settings_element',
		'slider' => 'slider',
		'struct' => 'struct',
		'struct_relations' => 'struct_relations',
		'users' => 'users',
    );
    unset($_ROOT);
?>