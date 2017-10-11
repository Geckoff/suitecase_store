<?php
    $Config = array(
    	'title' => 'Настройки',
        'data' => array(),
        'main_field' => 'value',
        'main_table' => 'settings',
    	'settings' => 'settings',
    	'settings_element' => 'settings_element',
    	'description' => true,
    	'url' => true,
    );
    $VERIFY = DB("SELECT `id` FROM `".$Config['settings']."` LIMIT 1");
    if (!isset($VERIFY[0]['id'])) {
        /*
        DB("CREATE TABLE IF NOT EXISTS `".$Config['settings']."` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `value` varchar(150) NOT NULL,
          `description` text,
          `delete` tinyint(1) NOT NULL DEFAULT '0',
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1");
        DB("CREATE TABLE IF NOT EXISTS `".$Config['settings_element']."` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `id_setting` int(11) NOT NULL,
          `sort` int(11) NOT NULL,
          `value` varchar(200) NOT NULL DEFAULT '',
          `name` varchar(255) NOT NULL DEFAULT '',
          `create` int(11) DEFAULT NULL,
          `delete` tinyint(1) NOT NULL DEFAULT '0',
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1");
        */
        DB("INSERT INTO `settings` (`value`, `description`) VALUES
                ('Телефон', '0'),
                ('E-mail', '0'),
                ('Адрес', NULL),
                ('Skype', NULL),
                ('Курсы валют', NULL)");       
    }
?>