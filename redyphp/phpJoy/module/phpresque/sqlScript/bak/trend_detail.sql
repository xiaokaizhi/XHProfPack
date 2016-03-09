SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for trend_log_detail
-- ----------------------------
DROP TABLE IF EXISTS `trend_detail`;
CREATE TABLE `trend_detail` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `url` varchar(2048) NOT NULL default '',
  `xhprofid` varchar(180) NOT NULL default '',
  `xhprofdata` text,
  `ct` int(10) unsigned NOT NULL default '0',
  `wt` int(10) unsigned NOT NULL default '0',
  `mu` int(10) unsigned NOT NULL default '0',
  `pmu` int(11) unsigned NOT NULL,
  `cpu` int(11) unsigned NOT NULL,
  `xhproftime` varchar(12) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
 
