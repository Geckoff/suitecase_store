<?php
	$Config = array(
		'main_table' => 'news_tree',	// Совершенно
		'main_field' => 'title',		// ненужная
		'data' => array(),				// информация...
		
		'title' => 'Акции',
		'name' => 'news',
		'version' => '2.2 dev',
		'table' => array(
			'tree' => 'news_tree',
			'item' => 'news_item',
			'item_images' => 'news_img',
		 ),
		 
		'common' => array(
			'count_per_page' => 10,
			'move_to_trash' => true,
			'no_photo' => 'no-photo.jpg',
			'no_photo_dir' => 'img/',
			'editor' => true
		),
		
		'section' => array(
			'file' => true,
		),
		
		'dir' => array(
			'tmp_dir' => '../data/temp/',
			'data_dir' => '../data/news/',
			'img' => array(
				'0' => array(
					'target' => 'cms',
					'dir' => 'cms_small/',
					'width' => '50',
					'height' => '50',
					'fit' => 'outside',
					'scale' => 'down',
				),
				'1' => array(
					'target' => 'cms',
					'dir' => 'cms_original/',
					'width' => '800',
					'height' => '600',
					'fit' => 'inside',
					'scale' => 'down',
				)
			)
		)
	);
	include_once dirname(__FILE__).'/defaults.php';
?>
