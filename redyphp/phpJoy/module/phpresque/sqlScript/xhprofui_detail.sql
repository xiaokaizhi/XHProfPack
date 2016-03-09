/*
Navicat MySQL Data Transfer

Source Server         : 10.210.227.126
Source Server Version : 50604
Source Host           : 10.210.227.126:3306
Source Database       : xhprofui

Target Server Type    : MYSQL
Target Server Version : 50604
File Encoding         : 65001

Date: 2014-05-28 11:03:06
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for xhprofui_detail
-- ----------------------------
DROP TABLE IF EXISTS `xhprofui_detail`;
CREATE TABLE `xhprofui_detail` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(2048) NOT NULL DEFAULT '',
  `host` varchar(512) NOT NULL DEFAULT '',
  `uri` varchar(1024) NOT NULL DEFAULT '',
  `c_url` varchar(2048) NOT NULL DEFAULT '',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `server_name` varchar(2048) NOT NULL DEFAULT '',
  `xhprof_id` varchar(180) NOT NULL DEFAULT '',
  `xhprof_data` text,
  `xhprof_time` varchar(15) NOT NULL DEFAULT '',
  `type` mediumint(4) unsigned NOT NULL DEFAULT '0',
  `data` text,
  `cookie` text,
  `post` text,
  `get` text,
  `ct` int(10) unsigned NOT NULL DEFAULT '0',
  `wt` int(10) unsigned NOT NULL DEFAULT '0',
  `mu` int(10) unsigned NOT NULL DEFAULT '0',
  `pmu` int(11) unsigned NOT NULL,
  `cpu` int(11) unsigned NOT NULL,
  `server_id` varchar(1024) NOT NULL DEFAULT '',
  `aggregateCalls_include` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `xhprof_id` (`xhprof_id`),
  KEY `url` (`url`(255)),
  KEY `c_url` (`c_url`(255)),
  KEY `cpu` (`cpu`),
  KEY `pmu` (`pmu`),
  KEY `timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xhprofui_detail
-- ----------------------------
