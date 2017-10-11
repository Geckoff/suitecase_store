CREATE TABLE IF NOT EXISTS `settings` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `value` varchar(150) NOT NULL,
    `description` text,
    `delete` tinyint(1) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `settings_element` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `id_setting` int(11) NOT NULL,
    `sort` int(11) NOT NULL DEFAULT '1',
    `value` varchar(200) NOT NULL DEFAULT '',
    `name` varchar(255) NOT NULL DEFAULT '',
    `create` int(11) DEFAULT NULL,
    `delete` tinyint(1) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;