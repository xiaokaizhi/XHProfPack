/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50515
Source Host           : 127.0.0.1:3306
Source Database       : trends

Target Server Type    : MYSQL
Target Server Version : 50515
File Encoding         : 65001

Date: 2014-05-20 08:42:28
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for sample
-- ----------------------------
DROP TABLE IF EXISTS `sample`;
CREATE TABLE `sample` (
  `sampleid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`sampleid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
