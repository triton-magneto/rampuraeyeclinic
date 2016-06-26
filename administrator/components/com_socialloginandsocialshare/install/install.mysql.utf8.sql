CREATE TABLE IF NOT EXISTS `#__loginradius_settings` (
	`id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`setting` varchar(255) NOT NULL,
	`value` varchar(1000) NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `setting` (`setting`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__loginradius_users` (
	`id` int(11),
	`loginradius_id` varchar(255) NULL,
	`provider` varchar(255) NULL,
	`lr_picture` varchar(255) NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;