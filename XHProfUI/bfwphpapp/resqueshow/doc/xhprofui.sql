-- phpMyAdmin SQL Dump
-- version 4.0.10.11
-- http://www.phpmyadmin.net
--
-- 主机: 10.48.23.51:8086
-- 生成日期: 2015-12-27 17:39:03
-- 服务器版本: 5.1.63
-- PHP 版本: 5.4.41

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `xhprofui`
--
CREATE DATABASE IF NOT EXISTS `xhprofui` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `xhprofui`;

-- --------------------------------------------------------

--
-- 表的结构 `xhprofui_detail`
--
-- 创建时间: 2015-03-19 03:30:09
-- 最后更新: 2015-07-23 07:14:42
--

DROP TABLE IF EXISTS `xhprofui_detail`;
CREATE TABLE IF NOT EXISTS `xhprofui_detail` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(2048) NOT NULL,
  `host` varchar(256) NOT NULL,
  `uri` varchar(256) NOT NULL,
  `xhprof_id` varchar(128) NOT NULL,
  `xhprof_data` longtext,
  `xhprof_time` varchar(32) NOT NULL,
  `ct` int(11) NOT NULL,
  `wt` int(11) NOT NULL,
  `mu` int(11) NOT NULL,
  `pmu` int(11) NOT NULL,
  `cpu` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3867 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
