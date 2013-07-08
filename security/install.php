<?php
include('config.php');

mysql_query("CREATE TABLE `votehistory` (
`id` int NOT NULL auto_increment,
`ipaddress` char(20) NOT NULL,
`user_id` int NOT NULL,
`time` int NOT NULL,
`cat` char(20) NOT NULL,
`item_id` int NOT NULL,
`vote` int NOT NULL,
PRIMARY KEY  (`id`)
) TYPE=MyISAM;") or die(mysql_error());

mysql_query("CREATE TABLE `user` (
`id` int NOT NULL auto_increment,
`username` char(30) NOT NULL,
`password` text NOT NULL,
`pri_email` char(50) text NOT NULL,
`pub_email` char(50) text NOT NULL,
`first_name` char(35) NOT NULL,
`last_name` char(35) NOT NULL,
`points` int NOT NULL,
`level` int NOT NULL,
`joined` int NOT NULL,
`last_visit` int NOT NULL,
`num_entries` int NOT NULL DEFAULT '0',
`num_posts` int NOT NULL DEFAULT '0',
`num_comments int NOT NULL DEFAULT '0'
`passkey` text NOT NULL,
PRIMARY KEY  (`id`)
) TYPE=MyISAM;") or die(mysql_error());

mysql_query("CREATE TABLE `friends` (
`user` int NOT NULL,
`friend` int NOT NULL,
`date` int NOT NULL
) TYPE=MyISAM;") or die(mysql_error());

mysql_query("CREATE TABLE `userlevel` (
`id` int NOT NULL,
`rank` int(10) NOT NULL DEFAULT '',
`title` char(35) NOT NULL,
`min` int(10) NOT NULL,
PRIMARY KEY  (`rank`)
) TYPE=MyISAM;") or die(mysql_error());

mysql_query("INSERT INTO `userlevel` VALUES (1,1,'New',0);") or die(mysql_error());
mysql_query("INSERT INTO `userlevel` VALUES (2,2,'Beginning',25);") or die(mysql_error());
mysql_query("INSERT INTO `userlevel` VALUES (3,3,'Regular',50);") or die(mysql_error());
mysql_query("INSERT INTO `userlevel` VALUES (4,4,'Frequent',100);") or die(mysql_error());
mysql_query("INSERT INTO `userlevel` VALUES (5,5,'Veteran',200);") or die(mysql_error());
mysql_query("INSERT INTO `userlevel` VALUES (6,6,'Elite',400);") or die(mysql_error());
mysql_query("INSERT INTO `userlevel` VALUES (7,7,'Icon',800);") or die(mysql_error());
mysql_query("INSERT INTO `userlevel` VALUES (8,8,'Hero',1000);") or die(mysql_error());
mysql_query("INSERT INTO `userlevel` VALUES (9,30,'VIP',0);") or die(mysql_error());
mysql_query("INSERT INTO `userlevel` VALUES (10,40,'Juror',0);") or die(mysql_error());
mysql_query("INSERT INTO `userlevel` VALUES (11,50,'Judge',0);") or die(mysql_error());

mysql_query("CREATE TABLE `modque` (
`id` int NOT NULL auto_increment,
`from` int NOT NULL,
`time` int NOT NULL,
`cat` char(20) NOT NULL,
`item_id` int NOT NULL,
`reason` char(50) NOT NULL,
`explain` text NOT NULL,
PRIMARY KEY  (`id`)
) TYPE=MyISAM;") or die(mysql_error());

mysql_query("CREATE TABLE `forumque` (
`id` int NOT NULL auto_increment,
`from` int NOT NULL,
`poster` int NOT NULL,
`time` int NOT NULL,
`mid` int NOT NULL,
`tid` int NOT NULL,
`bid` int NOT NULL,
`reason` char(50) NOT NULL,
PRIMARY KEY  (`id`)
) TYPE=MyISAM;") or die(mysql_error());

#CATEGORIES

/*mysql_query("CREATE TABLE `people` (
`id` int NOT NULL auto_increment,
`name` char(30) NOT NULL,
`date_added` int NOT NULL,
`start` int NOT NULL,
`end` int NOT NULL,
`birthplace` text NOT NULL,
`pic` char(250) NOT NULL,
`bio` text NOT NULL,
`added_by` char(35) NOT NULL,
`rate` FLOAT(3,2) NOT NULL,
PRIMARY KEY  (`id`)
) TYPE=MyISAM;") or die(mysql_error());*/

mysql_query("CREATE TABLE `song` (
`id` int NOT NULL auto_increment,
`name` char(30) NOT NULL,
`date_added` int NOT NULL,
`start` int NOT NULL,
`band` char(100) NOT NULL,
`album` char(100) NOT NULL,
`genre` char(20) NOT NULL,
`img` text NOT NULL,
`bio` text NOT NULL,
`added_by` int NOT NULL,
`rate` int NOT NULL,
`votes` int NOT NULL,
`tags` varchar(150) NOT NULL,
PRIMARY KEY  (`id`)
) TYPE=MyISAM;") or die(mysql_error());

mysql_query("CREATE TABLE `song_comment` (
`id` int NOT NULL auto_increment,
`from` int NOT NULL,
`time` int NOT NULL,
`item_id` int NOT NULL,
`comment` text NOT NULL,
PRIMARY KEY  (`id`)
) TYPE=MyISAM;") or die(mysql_error());

mysql_query("CREATE TABLE `movie` (
`id` int NOT NULL auto_increment,
`name` char(30) NOT NULL,
`date_added` int NOT NULL,
`start` int NOT NULL,
`studio` char(100) NOT NULL,
`genre` char(20) NOT NULL,
`director` char(100) NOT NULL,
`producer` char(100) NOT NULL,
`writer` char(100) NOT NULL,
`img` text NOT NULL,
`bio` text NOT NULL,
`added_by` int NOT NULL,
`rate` int NOT NULL,
`votes` int NOT NULL,
`tags` varchar(15) NOT NULL,
PRIMARY KEY  (`id`)
) TYPE=MyISAM;") or die(mysql_error());

mysql_query("CREATE TABLE `movie_comment` (
`id` int NOT NULL auto_increment,
`from` int NOT NULL,
`time` int NOT NULL,
`item_id` int NOT NULL,
`comment` text NOT NULL,
PRIMARY KEY  (`id`)
) TYPE=MyISAM;") or die(mysql_error());

#FORUMS

mysql_query("CREATE TABLE `forums` (
`board_id` int NOT NULL auto_increment,
`name` char(30) NOT NULL,
`category` tinyint(3) unsigned NOT NULL default '0',
`level_view` tinyint(4) NOT NULL default '1',
`level_post` tinyint(4) NOT NULL default '1',
`level_topic` tinyint(4) NOT NULL default '1',
`num_topics` int NOT NULL DEFAULT '0',
`num_posts` int NOT NULL DEFAULT '0',
PRIMARY KEY  (`board_id`)
) TYPE=MyISAM;") or die(mysql_error());

mysql_query("CREATE TABLE `forums_cats` (
`cat_id` int NOT NULL auto_increment,
`cat_name` char(30) NOT NULL,
`cat_order` tinyint(4) NOT NULL auto_increment DEFAULT '0',
`cat_min` tinyint(4) NOT NULL default '1',
PRIMARY KEY  (`cat_id`)
) TYPE=MyISAM;") or die(mysql_error());

mysql_query("CREATE TABLE `forums_messages` (
`message_id` int(11) NOT NULL auto_increment,
`message` text NOT NULL,
`poster_id` int(11) NOT NULL default '0',
`post_date` int(11) NOT NULL default '',
`topic_id` int(11) NOT NULL default '0',
`board_id` int(11) NOT NULL default '0',
`first` enum('yes','no') NOT NULL default 'no',
`reported` enum('yes','no') NOT NULL default 'no',
PRIMARY KEY (`message_id`)
) TYPE=MyISAM;") or die(mysql_error());

mysql_query("CREATE TABLE `forums_topics` (
`topic_id` int(11) NOT NULL auto_increment,
`title` char(200) NOT NULL,
`board` int(11) NOT NULL,
`creator_id` int  NOT NULL,
`create_date` int(11) NOT NULL,
`recent_date` int(11) NOT NULL,
`sticky` enum('yes','no') NOT NULL default 'no',
`status` enum('active','closed','reported') NOT NULL default 'active',
`posts` int NOT NULL default '0',
PRIMARY KEY (`topic_id`)
) TYPE=MyISAM;") or die(mysql_error());

mysql_query("CREATE TABLE `comics` (
`id` int(11) NOT NULL auto_increment,
`time` text NOT NULL,
`comic` text NOT NULL,
`tags` text NOT NULL,
`title` text NOT NULL,
PRIMARY KEY  (`id`)
) TYPE=MyISAM;") or die(mysql_error());
?>
