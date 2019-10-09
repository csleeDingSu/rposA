# Host: localhost  (Version: 5.5.53)
# Date: 2018-12-01 20:55:30
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "pengyou_content"
#

DROP TABLE IF EXISTS `pengyou_content`;
CREATE TABLE `pengyou_content` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  `time` varchar(30) DEFAULT NULL,
  `images_1` varchar(255) DEFAULT NULL,
  `images_2` varchar(255) DEFAULT NULL,
  `images_3` varchar(255) DEFAULT NULL,
  `images_4` varchar(255) DEFAULT NULL,
  `images_5` varchar(255) DEFAULT NULL,
  `images_6` varchar(255) DEFAULT NULL,
  `images_7` varchar(255) DEFAULT NULL,
  `images_8` varchar(255) DEFAULT NULL,
  `images_9` varchar(255) DEFAULT NULL,
  `shenhe` int(11) DEFAULT '0',
  `zhiding` int(2) DEFAULT '0',
  `zhidingtime` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;

#
# Data for table "pengyou_content"
#

/*!40000 ALTER TABLE `pengyou_content` DISABLE KEYS */;
INSERT INTO `pengyou_content` VALUES (1,'admin','Hello World！第二条数据，嘿嘿。','2018-08-24 20:15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2018-01-01 20:15'),(2,'admin','Hello World！第一条数据，嘿嘿。','2018-08-24 20:05',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL),(10,'admin','测试一下一张图','2018-08-27 22:56:18','15353817782.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL),(13,'admin','这是九宫格哦','2018-08-27 23:00:28','153538202868.jpg','153538202865.jpg','153538202874.jpg','153538202881.jpg','153538202848.jpg','153538202847.jpg','153538202849.jpg','153538202891.jpg','153538202871.jpg',0,0,NULL),(23,'123456','我也要发布第一条说说','2018-08-28 07:47:17',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL),(24,'123456','123','2018-08-28 08:00:28','153541442854.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL),(25,'123456','我要凑齐20条','2018-08-28 14:06:37',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL),(26,'123456','啊啊啊','2018-08-28 14:06:41',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL),(27,'admin','则儿子则在','2018-08-28 14:06:46',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL),(30,'admin','下拉加载数据啊','2018-08-28 14:07:12',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2018-01-24 20:15'),(36,'123456','还差\r\n','2018-08-28 14:08:16',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL),(39,'123456','按时打算啊','2018-08-28 14:11:04',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL),(41,'123456','啊啊啊','2018-09-11 17:50:14','153665941489.jpg','153665941437.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,0,'2018-10-10 15:30'),(44,'admin','啊啊啊啊','2018-10-07 19:20:48',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2018-10-11 15:30'),(47,'hello','啧啧啧啧额啧啧啧','2018-10-08 16:48:25',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL),(48,'匿名','阿斯顿撒旦啊','2018-10-10 22:14:39','15391808791.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL),(49,'admin','阿萨达','2018-11-10 16:12:43',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL);
/*!40000 ALTER TABLE `pengyou_content` ENABLE KEYS */;

#
# Structure for table "pengyou_feifa"
#

DROP TABLE IF EXISTS `pengyou_feifa`;
CREATE TABLE `pengyou_feifa` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) DEFAULT NULL,
  `time` varchar(255) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=56 DEFAULT CHARSET=utf8;

#
# Data for table "pengyou_feifa"
#

/*!40000 ALTER TABLE `pengyou_feifa` DISABLE KEYS */;
INSERT INTO `pengyou_feifa` VALUES (30,'192.168.1.10','2018-07-14 11:02:14','绕过前端提交数据'),(31,'192.168.1.10','2018-07-14 11:03:18','绕过前端提交数据'),(32,'192.168.1.10','2018-07-14 11:04:07','绕过前端提交数据'),(33,'192.168.1.10','2018-07-14 11:05:09','绕过前端提交数据'),(34,'192.168.1.10','2018-07-14 11:05:17','绕过前端提交数据'),(35,'192.168.1.10','2018-07-14 11:06:15','绕过前端提交数据'),(36,'192.168.1.10','2018-07-14 11:06:47','绕过前端提交数据'),(37,'192.168.1.10','2018-07-14 11:29:12','绕过前端提交数据'),(38,'192.168.1.10','2018-07-14 11:29:33','绕过前端提交数据'),(39,'192.168.1.10','2018-07-14 11:29:35','绕过前端提交数据'),(40,'192.168.1.10','2018-07-14 11:29:54','绕过前端提交数据'),(41,'192.168.1.10','2018-07-14 11:31:25','绕过前端提交数据'),(42,'192.168.1.10','2018-07-14 11:31:52','绕过前端提交数据'),(43,'192.168.1.10','2018-07-14 11:32:11','绕过前端提交数据'),(44,'192.168.1.10','2018-07-15 11:05:29','绕过前端提交数据'),(45,'192.168.1.10','2018-07-15 15:23:30','绕过前端提交数据'),(46,'','','绕过前端提交数据'),(47,'','','绕过前端提交数据'),(48,'127.0.0.1','2018-09-21 19:39:16','绕过前端提交删除数据'),(49,'','','绕过前端提交数据'),(50,'','','绕过前端提交数据'),(51,'','','绕过前端提交数据'),(52,'','','绕过前端提交数据'),(53,'','','绕过前端提交数据'),(54,'','','绕过前端提交数据'),(55,'','','绕过前端提交数据');
/*!40000 ALTER TABLE `pengyou_feifa` ENABLE KEYS */;

#
# Structure for table "pengyou_pinglun"
#

DROP TABLE IF EXISTS `pengyou_pinglun`;
CREATE TABLE `pengyou_pinglun` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL,
  `content` varchar(100) DEFAULT NULL,
  `time` varchar(30) DEFAULT NULL,
  `ip` varchar(30) DEFAULT NULL,
  `weiyibiaoshi` int(11) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `touser` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=87 DEFAULT CHARSET=utf8;

#
# Data for table "pengyou_pinglun"
#

/*!40000 ALTER TABLE `pengyou_pinglun` DISABLE KEYS */;
INSERT INTO `pengyou_pinglun` VALUES (59,'一奇','啦啦啦','2018-08-25 08:35:12','192.168.1.10',2,'admin',NULL),(60,'123456','啊啊啊','2018-09-11 17:52:56','127.0.0.1',40,'123456',NULL),(76,'123456','啊啊啊啊啊啊啊啊啊啊啊啊','2018-09-19 12:54:17','127.0.0.1',30,'123456',NULL),(77,'123456','啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊','2018-09-19 12:54:23','127.0.0.1',29,'123456',NULL),(78,'123456','啊啊啊啊啊啊啊啊啊啊啊啊啊啊','2018-09-19 12:54:27','127.0.0.1',30,'123456',NULL),(79,'123456','啊啊啊啊啊啊啊啊啊啊啊啊','2018-09-19 12:54:34','127.0.0.1',30,'123456',NULL);
/*!40000 ALTER TABLE `pengyou_pinglun` ENABLE KEYS */;

#
# Structure for table "pengyou_renzheng"
#

DROP TABLE IF EXISTS `pengyou_renzheng`;
CREATE TABLE `pengyou_renzheng` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `color` varchar(50) DEFAULT '#ffb400',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

#
# Data for table "pengyou_renzheng"
#

/*!40000 ALTER TABLE `pengyou_renzheng` DISABLE KEYS */;
INSERT INTO `pengyou_renzheng` VALUES (1,'校园认证啊','./images/icon/v2.png','#ffb400'),(2,'实名认证','./images/icon/v1.png','#ffb400'),(3,'大佬专用','./images/icon/v2.png','#ffb400'),(5,'vip','./images/icon/vip2.png','#d81e06'),(6,'svip','./images/icon/svip3.png','#e1c53f');
/*!40000 ALTER TABLE `pengyou_renzheng` ENABLE KEYS */;

#
# Structure for table "pengyou_shezhi"
#

DROP TABLE IF EXISTS `pengyou_shezhi`;
CREATE TABLE `pengyou_shezhi` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `qq` bigint(20) DEFAULT NULL,
  `shenhe` int(2) DEFAULT '0',
  `black` int(2) DEFAULT '0',
  `open` int(2) DEFAULT '0',
  `bg` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

#
# Data for table "pengyou_shezhi"
#

/*!40000 ALTER TABLE `pengyou_shezhi` DISABLE KEYS */;
INSERT INTO `pengyou_shezhi` VALUES (1,'校园朋友圈','www.q05.cc',330729121,0,0,0,'./images/bg.jpg');
/*!40000 ALTER TABLE `pengyou_shezhi` ENABLE KEYS */;

#
# Structure for table "pengyou_shiming"
#

DROP TABLE IF EXISTS `pengyou_shiming`;
CREATE TABLE `pengyou_shiming` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  `time` varchar(30) DEFAULT NULL,
  `images_1` varchar(255) DEFAULT NULL,
  `images_2` varchar(255) DEFAULT NULL,
  `images_3` varchar(255) DEFAULT NULL,
  `images_4` varchar(255) DEFAULT NULL,
  `images_5` varchar(255) DEFAULT NULL,
  `images_6` varchar(255) DEFAULT NULL,
  `images_7` varchar(255) DEFAULT NULL,
  `images_8` varchar(255) DEFAULT NULL,
  `images_9` varchar(255) DEFAULT NULL,
  `shenhe` int(11) DEFAULT '0',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;

#
# Data for table "pengyou_shiming"
#

/*!40000 ALTER TABLE `pengyou_shiming` DISABLE KEYS */;
INSERT INTO `pengyou_shiming` VALUES (44,'admin','哈哈哈哈哈哈哈','2018-09-17 16:33:03','153717318347.jpg','153717318311.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1);
/*!40000 ALTER TABLE `pengyou_shiming` ENABLE KEYS */;

#
# Structure for table "pengyou_user"
#

DROP TABLE IF EXISTS `pengyou_user`;
CREATE TABLE `pengyou_user` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `vip` char(20) DEFAULT '0',
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `openid` varchar(255) DEFAULT NULL,
  `name` varchar(20) DEFAULT NULL,
  `qq` bigint(14) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phone` int(11) DEFAULT NULL,
  `age` int(3) DEFAULT NULL,
  `xinbie` int(2) DEFAULT '0',
  `zcip` varchar(100) DEFAULT NULL,
  `dlip` varchar(100) DEFAULT NULL,
  `zctime` varchar(30) DEFAULT NULL,
  `dltime` varchar(30) DEFAULT NULL,
  `touxiang` varchar(50) DEFAULT 'morentouxiang.png',
  `guanli` int(11) DEFAULT '0',
  `finallyvip` int(2) DEFAULT '0',
  `bg` varchar(255) DEFAULT './images/bg.jpg',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

#
# Data for table "pengyou_user"
#

/*!40000 ALTER TABLE `pengyou_user` DISABLE KEYS */;
INSERT INTO `pengyou_user` VALUES (1,'[0,1,6]','admin','4297f44b13955235245b2497399d7a93',NULL,'一奇',330729121,'33072921@qq.com',15888888,18,0,'192.168.1.10','127.0.0.1','2018.06.04 19:55','2018-11-30 15:19:21','20181028071525.jpg',1,1,'./images/bg.jpg'),(2,'[1,2]','hello','e10adc3949ba59abbe56e057f20f883e',NULL,'付伟奇',10001,'10001@qq.com',1588496696,18,2,'192.168.1.10','127.0.0.1',NULL,'2018-10-08 16:47:51','20181008044812.jpeg',1,0,'./images/bg.jpg'),(3,'0','1588888881','e10adc3949ba59abbe56e057f20f883e',NULL,'哈哈哈哈哈',330729121,'1000000000000@qq.com',15888888,18,0,'192.168.1.1','192.168.1.10',NULL,NULL,'morentouxiang.png',0,0,'./images/bg.jpg'),(4,'1','123456','e10adc3949ba59abbe56e057f20f883e',NULL,NULL,NULL,'123456',NULL,NULL,0,'192.168.1.10','127.0.0.1','2018-06-07 21:46','2018-09-19 12:54:08','20180911054956.jpg',3,0,'./images/bg.jpg'),(5,'0','123','4297f44b13955235245b2497399d7a93',NULL,NULL,NULL,'123456',NULL,NULL,0,'192.168.1.10',NULL,'2018-06-07 21:47',NULL,'morentouxiang.png',1,0,'./images/bg.jpg'),(6,'0','1588','4297f44b13955235245b2497399d7a93',NULL,NULL,NULL,'1588',NULL,NULL,0,'192.168.1.10','192.168.1.10','2018-06-07 21:47','2018-06-07 22:05','morentouxiang.png',0,0,'./images/bg.jpg'),(7,'[1,2,3]','admin12','4297f44b13955235245b2497399d7a93',NULL,NULL,NULL,'d52f3fe3751f55c4149e04a165218a5a',NULL,NULL,0,'127.0.0.1',NULL,'2018-08-28 22:22:57',NULL,'morentouxiang.png',0,0,'./images/bg.jpg'),(8,'0','匿名','b9df7de3163570711b2f75d46fab4c02',NULL,NULL,NULL,'330729121@qq.com',NULL,NULL,0,'127.0.0.1',NULL,'2018-10-07 20:10:17',NULL,'morentouxiang.png',0,0,'./images/bg.jpg');
/*!40000 ALTER TABLE `pengyou_user` ENABLE KEYS */;

#
# Structure for table "pengyou_user_login_info"
#

DROP TABLE IF EXISTS `pengyou_user_login_info`;
CREATE TABLE `pengyou_user_login_info` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `ip` varchar(50) DEFAULT NULL,
  `time` varchar(50) DEFAULT NULL,
  `ok` int(3) DEFAULT '0',
  `cishu` int(3) DEFAULT '0',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=86 DEFAULT CHARSET=utf8;

#
# Data for table "pengyou_user_login_info"
#

/*!40000 ALTER TABLE `pengyou_user_login_info` DISABLE KEYS */;
INSERT INTO `pengyou_user_login_info` VALUES (30,'admin','192.168.1.10','2018-07-14 12:46:17',0,6),(31,'123456','192.168.1.10','2018-07-14 12:32:34',0,0),(32,'admin','192.168.1.10','2018-07-14 13:57:46',1,0),(33,'admin','192.168.1.10','2018-07-14 15:26:58',1,0),(34,'admin','192.168.1.10','2018-07-14 22:04:37',1,0),(35,'admin','192.168.1.10','2018-07-15 09:11:29',1,0),(36,'admin','192.168.1.10','2018-07-15 11:16:03',1,0),(37,'admin','192.168.1.10','2018-07-15 15:58:21',1,0),(38,'admin','192.168.1.10','2018-07-15 22:52:57',1,0),(39,'admin','192.168.1.10','2018-07-16 09:33:38',1,0),(40,'admin','192.168.1.10','2018-07-16 12:31:36',1,1),(41,'admin','192.168.1.10','2018-07-16 13:21:35',1,0),(42,'admin','192.168.1.10','2018-07-16 13:55:26',1,0),(43,'admin','192.168.1.10','2018-07-17 15:53:35',1,0),(44,'admin','192.168.1.10','2018-07-19 15:10:47',1,0),(45,'12312','192.168.1.10','2018-08-25 00:01:40',0,0),(46,'admin','192.168.1.10','2018-08-25 00:08:41',1,0),(47,'admin','192.168.1.10','2018-08-25 01:21:09',1,0),(48,'admin','192.168.1.10','2018-08-25 03:04:03',1,0),(49,'123456','192.168.1.10','2018-08-25 07:33:46',1,0),(50,'admin','192.168.1.10','2018-08-25 08:32:00',1,0),(51,'admin','127.0.0.1','2018-08-27 21:59:39',1,0),(52,'123456','127.0.0.1','2018-08-28 07:46:50',1,0),(53,'admin','127.0.0.1','2018-08-28 13:59:28',1,0),(54,'admin','127.0.0.1','2018-08-28 17:22:22',1,0),(55,'123456','127.0.0.1','2018-09-11 17:49:49',1,0),(56,'admin','127.0.0.1','2018-09-11 17:53:16',1,0),(57,'admin','127.0.0.1','2018-09-12 09:59:16',1,0),(58,'admin','127.0.0.1','2018-09-13 21:37:18',1,0),(59,'admin','127.0.0.1','2018-09-14 21:52:09',1,0),(60,'admin','127.0.0.1','2018-09-16 17:05:59',1,0),(61,'admin','127.0.0.1','2018-09-16 22:03:14',1,0),(62,'admin','127.0.0.1','2018-09-17 13:38:18',1,0),(63,'admin','127.0.0.1','2018-09-19 08:56:10',1,0),(64,'123456','127.0.0.1','2018-09-19 10:13:42',1,0),(65,'admin','127.0.0.1','2018-09-19 12:55:58',1,0),(66,'123456','127.0.0.1','2018-09-19 12:54:08',1,0),(67,'hello','127.0.0.1','2018-09-19 12:55:06',1,0),(68,'admin','127.0.0.1','2018-09-19 22:12:32',1,0),(69,'admin','172.20.10.1','2018-09-21 19:39:08',1,0),(70,'admin','127.0.0.1','2018-09-21 19:39:08',1,0),(71,'admin','127.0.0.1','2018-09-21 21:32:00',1,0),(72,'admin','127.0.0.1','2018-09-24 20:39:12',1,0),(73,'admin','127.0.0.1','2018-09-26 10:36:56',1,0),(74,'admin','127.0.0.1','2018-10-07 19:29:28',1,0),(75,'admin','127.0.0.1','2018-10-07 20:28:26',1,0),(76,'admin','127.0.0.1','2018-10-08 10:28:45',1,0),(77,'admin','192.168.1.105','2018-10-08 16:07:18',1,0),(78,'hello','127.0.0.1','2018-10-08 16:47:51',1,0),(79,'admin','127.0.0.1','2018-10-08 22:07:48',1,0),(80,'admin','127.0.0.1','2018-10-09 18:54:25',1,0),(81,'admin','127.0.0.1','2018-10-10 10:03:11',1,0),(82,'admin','127.0.0.1','2018-10-10 11:31:25',1,0),(83,'admin','127.0.0.1','2018-10-10 22:17:10',1,0),(84,'admin','127.0.0.1','2018-10-12 09:49:10',1,0),(85,'admin','127.0.0.1','2018-11-30 15:19:21',1,0);
/*!40000 ALTER TABLE `pengyou_user_login_info` ENABLE KEYS */;

#
# Structure for table "pengyou_user_reg_info"
#

DROP TABLE IF EXISTS `pengyou_user_reg_info`;
CREATE TABLE `pengyou_user_reg_info` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) DEFAULT NULL,
  `time` varchar(50) DEFAULT NULL,
  `ok` int(3) DEFAULT '0',
  `cishu` int(3) DEFAULT '0',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

#
# Data for table "pengyou_user_reg_info"
#

/*!40000 ALTER TABLE `pengyou_user_reg_info` DISABLE KEYS */;
/*!40000 ALTER TABLE `pengyou_user_reg_info` ENABLE KEYS */;

#
# Structure for table "pengyou_zan"
#

DROP TABLE IF EXISTS `pengyou_zan`;
CREATE TABLE `pengyou_zan` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(100) DEFAULT NULL,
  `weiyibiaoshi` int(11) DEFAULT NULL,
  `time` varchar(30) DEFAULT NULL,
  `username` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=145 DEFAULT CHARSET=utf8;

#
# Data for table "pengyou_zan"
#

/*!40000 ALTER TABLE `pengyou_zan` DISABLE KEYS */;
INSERT INTO `pengyou_zan` VALUES (58,'192.168.1.10',1,'2018-08-25 07:34:30','123456'),(59,'192.168.1.10',2,'2018-08-25 07:34:35','123456'),(62,'192.168.1.10',1,'2018-08-25 08:35:03','admin'),(94,'127.0.0.1',41,'2018-09-11 17:52:50','123456'),(95,'127.0.0.1',40,'2018-09-11 17:52:51','123456'),(99,'127.0.0.1',41,'2018-09-11 20:30','hello'),(139,'192.168.1.105',44,'2018-10-08 16:07:30','admin'),(142,'127.0.0.1',47,'2018-10-08 21:19:32','hello'),(143,'127.0.0.1',44,'2018-10-08 21:52:21','hello');
/*!40000 ALTER TABLE `pengyou_zan` ENABLE KEYS */;
