<?php
	$Config = array(
		'main_table' => 'catalog_tree',	// Совершенно
		'main_field' => 'title',		// ненужная
		'data' => array(),				// информация...
		
		'title' => 'Каталог',
		'name' => 'catalog',
		'version' => '2.2 dev',
		'table' => array(
			'tree' => 'catalog_tree',
			'item' => 'catalog_item',
			'item_images' => 'catalog_img',
			'tree_params' => 'catalog_parameters',
			'item_params' => 'catalog_item_parameters'
		 ),
		 
		'common' => array(
			'count_per_page' => 10,
			'move_to_trash' => true,
			'no_photo' => 'no-photo.jpg',
			'no_photo_dir' => 'img/',
			'editor' => true
		),
		
		'section' => array(
			'available' => true,
			'featured' => true,
			'special' => true,
			'price' => true,
			'discount' => true,
			'file' => false,
			'parameters' => true
		),
		
		'currency' => array(
			'USD' => 'float',
			'EUR' => 'float',
			'RU' => 'float',
			'BYR' => 'int',
		),
		
		'dir' => array(
			'tmp_dir' => '../data/temp/',
			'data_dir' => '../data/catalog/',
			'img' => array(
				'0' => array(
					'target' => 'cms',
					'dir' => 'cms_small/',
					'width' => '50',
					'height' => '50',
					'fit' => 'outside',
					'scale' => 'any',
				),
				'1' => array(
					'target' => 'cms',
					'dir' => 'cms_original/',
					'width' => '1000',
					'height' => '1000',
					'fit' => 'inside',
					'scale' => 'any',
				),
				'2' => array(
					'target' => 'user',
					'dir' => 'large/',
					'width' => '304',
					'height' => '304',
					'fit' => 'inside',
					'scale' => 'any',
				),
				'3' => array(
					'target' => 'user',
					'dir' => 'medium/',
					'width' => '194',
					'height' => '194',
					'fit' => 'inside',
					'scale' => 'any',
				),
				'4' => array(
					'target' => 'user',
					'dir' => 'small/',
					'width' => '80',
					'height' => '80',
					'fit' => 'inside',
					'scale' => 'any',
				),
			)
		)
	);
	include_once dirname(__FILE__).'/defaults.php';
	/*if(!file_exists('user.php')){
		include_once dirname(__FILE__).'/defaults.php';
		#eval(file_get_contents(dirname(__FILE__).'/defaults.php'));
	} else{
		include_once dirname(__FILE__).'/user.php';
	}*/
/*
	file_put_contents('user.php',"<?php\n\$Config = ".var_export($Config, true).";\n?>");
*/
?>
