CREATE TABLE IF NOT EXISTS `struct` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `sort` int(11) unsigned NOT NULL,
  `parent` int(11) unsigned NOT NULL,
  `menu_title` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  `url` varchar(255) NOT NULL default '',
  `text` mediumtext NOT NULL,
  `meta_title` varchar(255) NOT NULL default '',
  `meta_keywords` varchar(255) NOT NULL default '',
  `meta_description` text NOT NULL,	
  `active` tinyint(1) NOT NULL default '1',
  `delete` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `struct_relations` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `id_struct` int(11) unsigned NOT NULL,
  `id_module` int(11) unsigned NOT NULL,
  `id_main_field` int(11) unsigned NOT NULL default '0',
  `id_page` int(11) unsigned NOT NULL,
  `active` tinyint(1) NOT NULL default '1',
  `delete` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;