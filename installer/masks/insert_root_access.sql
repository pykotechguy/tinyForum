INSERT INTO `{dbprefix}users` (`user_id`, `username`, `password`, `first_name`, `email`, `role`, `active`, `regdate`) 
VALUES (NULL, '{admin_username}', '{admin_password}', '{admin_realname}', '{admin_email}', 'Administrator', '1', '2012-12-25 14:00:00');

INSERT INTO `{dbprefix}options` (`option_id`, `option_name`, `option_value`) VALUES(1, 'admin_email', '{admin_email}');

INSERT INTO `{dbprefix}options` (`option_id`, `option_name`, `option_value`) VALUES(2, 'forum_name', '{sitetitle}');

INSERT INTO `{dbprefix}options` (`option_id`, `option_name`, `option_value`) VALUES(3, 'thcount', '10');

INSERT INTO `{dbprefix}options` (`option_id`, `option_name`, `option_value`) VALUES(4, 'ptcount', '10');

INSERT INTO `{dbprefix}options` (`option_id`, `option_name`, `option_value`) VALUES(5, 'cookieexpire', '3600');

INSERT INTO `{dbprefix}options` (`option_id`, `option_name`, `option_value`) VALUES(6, 'cookiepath', '/');

INSERT INTO `{dbprefix}options` (`option_id`, `option_name`, `option_value`) VALUES(7, 'cache', 'Yes');

INSERT INTO `{dbprefix}options` (`option_id`, `option_name`, `option_value`) VALUES(8, 'cacheTTL', '1800');

INSERT INTO `{dbprefix}options` (`option_id`, `option_name`, `option_value`) VALUES(9, 'facebook', '');

INSERT INTO `{dbprefix}options` (`option_id`, `option_name`, `option_value`) VALUES(10, 'flickr', '');

INSERT INTO `{dbprefix}options` (`option_id`, `option_name`, `option_value`) VALUES(11, 'googleplus', '');

INSERT INTO `{dbprefix}options` (`option_id`, `option_name`, `option_value`) VALUES(12, 'twitter', '');

INSERT INTO `{dbprefix}options` (`option_id`, `option_name`, `option_value`) VALUES(13, 'vimeo', '');