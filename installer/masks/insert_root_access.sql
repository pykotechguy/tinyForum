INSERT INTO `{dbprefix}users` (`user_id`, `username`, `password`, `first_name`, `email`, `role`, `active`) 
VALUES (NULL, '{admin_username}', '{admin_password}', '{admin_realname}', '{admin_email}', 'Administrator', '1');

INSERT INTO `{dbprefix}options` (`option_id`, `option_name`, `option_value`) VALUES(1, 'admin_email', '{admin_email}');

INSERT INTO `{dbprefix}options` (`option_id`, `option_name`, `option_value`) VALUES(2, 'forum_name', '{sitetitle}');

INSERT INTO `{dbprefix}options` (`option_id`, `option_name`, `option_value`) VALUES(3, 'thcount', '10');

INSERT INTO `{dbprefix}options` (`option_id`, `option_name`, `option_value`) VALUES(4, 'ptcount', '10');

INSERT INTO `{dbprefix}options` (`option_id`, `option_name`, `option_value`) VALUES(5, 'cookieexpire', '3600');

INSERT INTO `{dbprefix}options` (`option_id`, `option_name`, `option_value`) VALUES(6, 'cookiepath', '/');

INSERT INTO `{dbprefix}options` (`option_id`, `option_name`, `option_value`) VALUES(7, 'facebook', '');

INSERT INTO `{dbprefix}options` (`option_id`, `option_name`, `option_value`) VALUES(8, 'flickr', '');

INSERT INTO `{dbprefix}options` (`option_id`, `option_name`, `option_value`) VALUES(9, 'googleplus', '');

INSERT INTO `{dbprefix}options` (`option_id`, `option_name`, `option_value`) VALUES(10, 'twitter', '');

INSERT INTO `{dbprefix}options` (`option_id`, `option_name`, `option_value`) VALUES(11, 'vimeo', '');