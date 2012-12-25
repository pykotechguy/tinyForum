CREATE TABLE `{dbprefix}forums` (
  `fid` int(8) NOT NULL AUTO_INCREMENT,
  `permission` varchar(1) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `sort` int(11) NOT NULL,
  PRIMARY KEY (`fid`),
  UNIQUE KEY `name_unique` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO `{dbprefix}forums` (`fid`, `permission`, `name`, `description`, `sort`) VALUES(1, 'Y', 'General', 'General forum for news and announcements.', 1);

CREATE TABLE `{dbprefix}options` (
  `option_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `option_name` varchar(64) NOT NULL DEFAULT '',
  `option_value` longtext NOT NULL,
  PRIMARY KEY (`option_id`),
  UNIQUE KEY `option_name` (`option_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE `{dbprefix}posts` (
  `post_id` int(8) NOT NULL AUTO_INCREMENT,
  `post_content` text NOT NULL,
  `post_date` datetime NOT NULL,
  `post_topic` int(8) NOT NULL,
  `post_by` int(8) NOT NULL,
  PRIMARY KEY (`post_id`),
  KEY `post_topic` (`post_topic`),
  KEY `post_by` (`post_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE `{dbprefix}topics` (
  `topic_id` int(8) NOT NULL AUTO_INCREMENT,
  `topic_subject` varchar(255) NOT NULL,
  `topic_date` datetime NOT NULL,
  `topic_fid` int(8) NOT NULL,
  `topic_by` int(8) NOT NULL,
  PRIMARY KEY (`topic_id`),
  KEY `topic_fid` (`topic_fid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE `{dbprefix}users` (
  `user_id` int(8) NOT NULL AUTO_INCREMENT,
  `md5_id` varchar(255) NOT NULL,
  `username` varchar(30) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `facebook` varchar(64) NOT NULL,
  `twitter` varchar(64) NOT NULL,
  `googleplus` varchar(64) NOT NULL,
  `linkedin` varchar(64) NOT NULL,
  `auth_token` varchar(255) NOT NULL,
  `role` enum('Administrator','Moderator','Member') NOT NULL DEFAULT 'Member',
  `activation_code` int(10) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `regdate` datetime NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

ALTER TABLE `{dbprefix}topics` ADD FOREIGN KEY(topic_fid) REFERENCES {dbprefix}forums(fid) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `{dbprefix}topics` ADD FOREIGN KEY(topic_by) REFERENCES {dbprefix}users(user_id) ON DELETE RESTRICT ON UPDATE CASCADE;

ALTER TABLE `{dbprefix}posts` ADD FOREIGN KEY(post_topic) REFERENCES {dbprefix}topics(topic_id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `{dbprefix}posts` ADD FOREIGN KEY(post_by) REFERENCES {dbprefix}users(user_id) ON DELETE RESTRICT ON UPDATE CASCADE;