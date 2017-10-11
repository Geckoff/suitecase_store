--
-- Структура таблицы `catalog_tree`
--

CREATE TABLE IF NOT EXISTS `catalog_tree` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_tree` int(11) unsigned NOT NULL DEFAULT '0',
  `sort` int(11) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `description` text,
  `fname` varchar(255) NOT NULL DEFAULT '',
  `seo_title` varchar(255) NOT NULL DEFAULT '',
  `seo_keywords` varchar(255) NOT NULL DEFAULT '',
  `seo_description` text,
  `changed` int(11) unsigned NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `delete` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Структура таблицы `catalog_item`
--

CREATE TABLE IF NOT EXISTS `catalog_item` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_tree` int(11) unsigned NOT NULL,
  `sort` int(11) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `description` text,
  `fname` varchar(255) NOT NULL DEFAULT '',
  `seo_title` varchar(255) NOT NULL DEFAULT '',
  `seo_keywords` varchar(255) NOT NULL DEFAULT '',
  `seo_description` text,
  `popularity` int(11) NOT NULL DEFAULT '0',
  `price` double NOT NULL DEFAULT '0',
  `available` tinyint(1) NOT NULL DEFAULT '1',
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `special` tinyint(1) NOT NULL DEFAULT '0',
  `discount` tinyint(1) NOT NULL DEFAULT '0',
  `ds_type` tinyint(1) NOT NULL DEFAULT '0',
  `ds_value` varchar(10) NOT NULL DEFAULT '',
  `ds_user_value` varchar(10) NOT NULL DEFAULT '',
  `ds_price` double NOT NULL DEFAULT '0',
  `changed` int(11) unsigned NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `delete` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Структура таблицы `catalog_img`
--

CREATE TABLE IF NOT EXISTS `catalog_img` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_item` int(11) unsigned NOT NULL,
  `sort` int(11) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT '',
  `alt` varchar(255) NOT NULL DEFAULT '',
  `fname` varchar(255) NOT NULL,
  `primary` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id_item` (`id_item`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Структура таблицы `catalog_parameters`
--

CREATE TABLE IF NOT EXISTS `catalog_parameters` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_tree` int(11) unsigned NOT NULL,
  `id_group` int(11) unsigned NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `help` text,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `delete` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id_tree` (`id_tree`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


--
-- Структура таблицы `catalog_item_parameters`
--

CREATE TABLE IF NOT EXISTS `catalog_item_parameters` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_item` int(11) unsigned NOT NULL,
  `id_parameter` int(11) unsigned NOT NULL,
  `value` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `secondary` (`id_item`, `id_parameter`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
