<?php
$Config = array(
	'title' => 'Слайдер',
	'image' => 'module-slider.png',
	'slider' => 'slider',
	'main_table' => 'slider',
	'main_field' => 'title',
	'width' => 200,
	'height' => 200,
	'data' => array('path' => 'original'),
	'paths' => array('path' => $AdminConfig['DATA_ROOT'].'/slider/original'),
	'description' => true,
	'url' => true
);
$FILE = array('temp'=>'../data/temp/',
			'path'=>'../data/slider/',
			'images'=>array(array('path'=>'original/',
							'width'=>'708',
							'height'=>'394'),
							)
			);
?>
