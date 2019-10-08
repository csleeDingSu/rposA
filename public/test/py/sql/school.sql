# Host: localhost  (Version: 5.5.53)
# Date: 2018-12-07 13:44:42
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "student"
#

DROP TABLE IF EXISTS `student`;
CREATE TABLE `student` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `xuehao` varchar(100) DEFAULT NULL,
  `name` varchar(30) DEFAULT NULL,
  `xingbie` int(2) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `xueyuan` varchar(100) DEFAULT NULL,
  `zhuanye` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "student"
#

/*!40000 ALTER TABLE `student` DISABLE KEYS */;
INSERT INTO `student` VALUES (1,'18450101152658','谭恺昕',2,'13877172549','大数据与软件学院','计算机科学与技术'),(2,'18450101152665','罗宇舟',1,'18076361433','大数据与软件学院','数据科学与大数据技术'),(3,'18130105151756','陈若凡',1,'13731137858','大数据与软件学院','计算机科学与技术');
/*!40000 ALTER TABLE `student` ENABLE KEYS */;
