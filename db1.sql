# Host: 127.0.0.1  (Version: 5.7.26)
# Date: 2021-05-13 11:25:45
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "product"
#

CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(2550) DEFAULT NULL,
  `titleimg` varchar(2550) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `topimgs` text,
  `topimgm` text,
  `topimgb` text,
  `content` text,
  `url` varchar(2550) DEFAULT NULL,
  `categoryid` int(11) DEFAULT NULL,
  `spiderid` int(11) DEFAULT NULL,
  `store` varchar(2550) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `is_delete` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=53291 DEFAULT CHARSET=utf8;

#
# Structure for table "question"
#

CREATE TABLE `question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(2550) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `content` text,
  `url` varchar(2550) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Structure for table "spider"
#

CREATE TABLE `spider` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(2000) DEFAULT NULL,
  `img` varchar(2000) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `store` varchar(100) DEFAULT NULL,
  `tag` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `url` varchar(3555) DEFAULT NULL,
  `categoryid` int(11) DEFAULT NULL,
  `content` text,
  `date2` datetime DEFAULT NULL,
  `topimgs` text,
  `topimgm` text,
  `topimgb` text,
  `is_delete` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=53278 DEFAULT CHARSET=utf8;

#
# Structure for table "urls"
#

CREATE TABLE `urls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(3550) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `tag` varchar(255) DEFAULT NULL,
  `date2` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1806 DEFAULT CHARSET=utf8;

#
# Structure for table "user"
#

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `authority` varchar(255) DEFAULT NULL,
  `updatedate` datetime DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

#
# Structure for table "userinfo"
#

CREATE TABLE `userinfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `logindate` datetime DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
