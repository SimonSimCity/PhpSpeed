-- phpMyAdmin SQL Dump
-- version 2.7.0-pl2
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Nov 05, 2006 at 04:43 PM
-- Server version: 4.1.20
-- PHP Version: 5.0.4
-- 
-- Database: `phpspeed`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `phpspeed_config`
-- 

CREATE TABLE `phpspeed_config` (
  `version` varchar(20) NOT NULL default '',
  `tests_run` int(25) NOT NULL default '0',
  `last_test` varchar(25) NOT NULL default ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `phpspeed_config`
-- 

INSERT INTO `phpspeed_config` (`version`, `tests_run`, `last_test`) VALUES ('1.0 beta', 0, '');

-- --------------------------------------------------------

-- 
-- Table structure for table `results1`
-- 

CREATE TABLE `results1` (
  `testid` int(20) NOT NULL auto_increment,
  `timestamp` varchar(20) NOT NULL default '0',
  `cpu` varchar(50) NOT NULL default '',
  `uptime` varchar(50) NOT NULL default '',
  `memory` varchar(50) NOT NULL default '',
  `phpspeed_version` varchar(50) NOT NULL default '',
  `php_version` varchar(50) NOT NULL default '',
  `mysql_version` varchar(50) NOT NULL default '',
  `server_software` text NOT NULL,
  `test_results` text NOT NULL,
  `tests_run` int(20) NOT NULL default '0',
  `iterations` int(20) NOT NULL default '0',
  `total_time` int(50) NOT NULL default '0',
  `score` int(20) NOT NULL default '0',
  `site` varchar(250) NOT NULL default '',
  PRIMARY KEY  (`testid`),
  KEY `testid` (`score`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `results1`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `results2`
-- 

CREATE TABLE `results2` (
  `testid` int(20) NOT NULL auto_increment,
  `timestamp` varchar(20) NOT NULL default '0',
  `cpu` varchar(50) NOT NULL default '',
  `uptime` varchar(50) NOT NULL default '',
  `memory` varchar(50) NOT NULL default '',
  `phpspeed_version` varchar(50) NOT NULL default '',
  `php_version` varchar(50) NOT NULL default '',
  `mysql_version` varchar(50) NOT NULL default '',
  `server_software` text NOT NULL,
  `test_results` text NOT NULL,
  `tests_run` int(20) NOT NULL default '0',
  `iterations` int(20) NOT NULL default '0',
  `total_time` int(50) NOT NULL default '0',
  `score` int(20) NOT NULL default '0',
  `site` varchar(250) NOT NULL default '',
  PRIMARY KEY  (`testid`),
  KEY `testid` (`score`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `results2`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `results3`
-- 

CREATE TABLE `results3` (
  `testid` int(20) NOT NULL auto_increment,
  `timestamp` varchar(20) NOT NULL default '0',
  `cpu` varchar(50) NOT NULL default '',
  `uptime` varchar(50) NOT NULL default '',
  `memory` varchar(50) NOT NULL default '',
  `phpspeed_version` varchar(50) NOT NULL default '',
  `php_version` varchar(50) NOT NULL default '',
  `mysql_version` varchar(50) NOT NULL default '',
  `server_software` text NOT NULL,
  `test_results` text NOT NULL,
  `tests_run` int(20) NOT NULL default '0',
  `iterations` int(20) NOT NULL default '0',
  `total_time` int(50) NOT NULL default '0',
  `score` int(20) NOT NULL default '0',
  `site` varchar(250) NOT NULL default '',
  PRIMARY KEY  (`testid`),
  KEY `testid` (`score`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `results3`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `results4`
-- 

CREATE TABLE `results4` (
  `testid` int(20) NOT NULL auto_increment,
  `timestamp` varchar(20) NOT NULL default '0',
  `cpu` varchar(50) NOT NULL default '',
  `uptime` varchar(50) NOT NULL default '',
  `memory` varchar(50) NOT NULL default '',
  `phpspeed_version` varchar(50) NOT NULL default '',
  `php_version` varchar(50) NOT NULL default '',
  `mysql_version` varchar(50) NOT NULL default '',
  `server_software` text NOT NULL,
  `test_results` text NOT NULL,
  `tests_run` int(20) NOT NULL default '0',
  `iterations` int(20) NOT NULL default '0',
  `total_time` int(50) NOT NULL default '0',
  `score` int(20) NOT NULL default '0',
  `site` varchar(250) NOT NULL default '',
  PRIMARY KEY  (`testid`),
  KEY `testid` (`score`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `results4`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `results5`
-- 

CREATE TABLE `results5` (
  `testid` int(20) NOT NULL auto_increment,
  `timestamp` varchar(20) NOT NULL default '0',
  `cpu` varchar(50) NOT NULL default '',
  `uptime` varchar(50) NOT NULL default '',
  `memory` varchar(50) NOT NULL default '',
  `phpspeed_version` varchar(50) NOT NULL default '',
  `php_version` varchar(50) NOT NULL default '',
  `mysql_version` varchar(50) NOT NULL default '',
  `server_software` text NOT NULL,
  `test_results` text NOT NULL,
  `tests_run` int(20) NOT NULL default '0',
  `iterations` int(20) NOT NULL default '0',
  `total_time` int(50) NOT NULL default '0',
  `score` int(20) NOT NULL default '0',
  `site` varchar(250) NOT NULL default '',
  PRIMARY KEY  (`testid`),
  KEY `testid` (`score`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `results5`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `results6`
-- 

CREATE TABLE `results6` (
  `testid` int(20) NOT NULL auto_increment,
  `timestamp` varchar(20) NOT NULL default '0',
  `cpu` varchar(50) NOT NULL default '',
  `uptime` varchar(50) NOT NULL default '',
  `memory` varchar(50) NOT NULL default '',
  `phpspeed_version` varchar(50) NOT NULL default '',
  `php_version` varchar(50) NOT NULL default '',
  `mysql_version` varchar(50) NOT NULL default '',
  `server_software` text NOT NULL,
  `test_results` text NOT NULL,
  `tests_run` int(20) NOT NULL default '0',
  `iterations` int(20) NOT NULL default '0',
  `total_time` int(50) NOT NULL default '0',
  `score` int(20) NOT NULL default '0',
  `site` varchar(250) NOT NULL default '',
  PRIMARY KEY  (`testid`),
  KEY `testid` (`score`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `results6`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `test_table`
-- 

CREATE TABLE `test_table` (
  `t1` varchar(50) NOT NULL default '',
  `t2` varchar(50) NOT NULL default '',
  `t3` varchar(50) NOT NULL default '',
  `t4` varchar(50) NOT NULL default '',
  `t5` varchar(50) NOT NULL default '',
  `t6` varchar(50) NOT NULL default '',
  `t7` varchar(50) NOT NULL default '',
  `t8` varchar(50) NOT NULL default '',
  `t9` text NOT NULL,
  `t10` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `test_table`
-- 

