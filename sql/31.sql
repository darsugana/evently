-- phpMyAdmin SQL Dump
-- version 3.0.0-rc1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 08, 2009 at 09:16 PM
-- Server version: 5.0.67
-- PHP Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `evently`
--

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

DROP TABLE IF EXISTS `event`;
CREATE TABLE IF NOT EXISTS `event` (
  `event_id` int(11) NOT NULL auto_increment,
  `source_id` int(11) NOT NULL,
  `raw_rss_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date` datetime NOT NULL,
  `guid` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `latitude` float default NULL,
  `longitude` float default NULL,
  `date_published` datetime NOT NULL,
  `date_modified` timestamp NULL default NULL on update CURRENT_TIMESTAMP,
  `date_created` datetime NOT NULL,
  `is_deleted` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`event_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;


-- --------------------------------------------------------

--
-- Table structure for table `raw_rss`
--

DROP TABLE IF EXISTS `raw_rss`;
CREATE TABLE IF NOT EXISTS `raw_rss` (
  `raw_rss_id` int(11) unsigned NOT NULL auto_increment,
  `source_id` int(11) NOT NULL,
  `raw_rss_data` text NOT NULL,
  `is_imported` tinyint(1) NOT NULL default '0',
  `last_build_date` datetime NOT NULL,
  `date_modified` timestamp NULL default NULL on update CURRENT_TIMESTAMP,
  `date_created` datetime default NULL,
  `is_deleted` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`raw_rss_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6790 ;

-- --------------------------------------------------------

--
-- Table structure for table `source`
--

DROP TABLE IF EXISTS `source`;
CREATE TABLE IF NOT EXISTS `source` (
  `source_id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `feed` varchar(255) NOT NULL,
  `date_modified` timestamp NULL default NULL on update CURRENT_TIMESTAMP,
  `date_created` datetime NOT NULL,
  `is_deleted` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`source_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `source`
--

INSERT INTO `source` (`source_id`, `name`, `feed`, `date_modified`, `date_created`, `is_deleted`) VALUES
(1, 'Upcoming', 'http://upcoming.yahoo.com/syndicate/v2/search_all/?loc=Austin&rt=1', NULL, '2008-09-28 01:43:32', 0);

-- --------------------------------------------------------

--
-- Table structure for table `spider_event`
--

DROP TABLE IF EXISTS `spider_event`;
CREATE TABLE IF NOT EXISTS `spider_event` (
  `spider_event_id` int(11) NOT NULL auto_increment,
  `source_id` int(11) NOT NULL,
  `raw_rss_id` int(11) default NULL,
  `spider_status_id` int(11) NOT NULL,
  `date_created` datetime default NULL,
  `date_modified` timestamp NULL default NULL on update CURRENT_TIMESTAMP,
  `is_deleted` tinyint(1) NOT NULL,
  PRIMARY KEY  (`spider_event_id`),
  KEY `spider_event_id` (`spider_event_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=7 ;


-- --------------------------------------------------------

--
-- Table structure for table `spider_status`
--

DROP TABLE IF EXISTS `spider_status`;
CREATE TABLE IF NOT EXISTS `spider_status` (
  `spider_status_id` int(11) NOT NULL,
  `spider_status` varchar(255) NOT NULL,
  PRIMARY KEY  (`spider_status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `spider_status`
--

INSERT INTO `spider_status` (`spider_status_id`, `spider_status`) VALUES
(1, 'attempted connection'),
(2, 'saved new raw rss'),
(3, 'discarded raw rss because lastBuildDate isn''t new'),
(4, 'couldn''t find a feed at url');
