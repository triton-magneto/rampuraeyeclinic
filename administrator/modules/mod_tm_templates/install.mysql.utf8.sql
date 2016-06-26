
-- UPDATE `#__modules` SET `id` =  '200' WHERE  `#__modules`.`module` = 'mod_tm_templates';
-- UPDATE `#__modules` SET `ordering` =  '5', `position` =  'cpanel', `published` =  '1' WHERE  `#__modules`.`module` = 'mod_tm_templates';

-- INSERT INTO `#__modules_menu` (`moduleid`, `menuid`) VALUES ('200', '0')
-- ON DUPLICATE KEY UPDATE  `#__modules_menu`.`menuid` = '0';

INSERT INTO `#__modules_menu` (`moduleid`, `menuid`) SELECT `id`, 0 FROM `#__modules` WHERE `module` = 'mod_tm_templates'
ON DUPLICATE KEY UPDATE  `#__modules_menu`.`menuid` = '0';

UPDATE `#__modules` SET `ordering` =  '5', `position` =  'cpanel', `published` =  '1' WHERE  `#__modules`.`module` = 'mod_tm_templates';