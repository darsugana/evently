-- phpMyAdmin SQL Dump
-- version 3.0.0-beta
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 05, 2008 at 01:55 PM
-- Server version: 5.0.51
-- PHP Version: 5.2.4-2ubuntu5.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `events`
--

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

DROP TABLE IF EXISTS `event`;
CREATE TABLE `event` (
  `event_id` int(11) unsigned NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `raw_rss`
--

DROP TABLE IF EXISTS `raw_rss`;
CREATE TABLE `raw_rss` (
  `raw_rss_id` int(11) unsigned NOT NULL auto_increment,
  `source_id` int(11) NOT NULL,
  `raw_rss_data` text NOT NULL,
  `is_imported` tinyint(1) NOT NULL default '0',
  `date_modified` timestamp NULL default NULL on update CURRENT_TIMESTAMP,
  `date_created` datetime default NULL,
  `is_deleted` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`raw_rss_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6781 ;

-- --------------------------------------------------------

--
-- Table structure for table `source`
--

DROP TABLE IF EXISTS `source`;
CREATE TABLE `source` (
  `source_id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `feed` varchar(255) NOT NULL,
  `date_modified` timestamp NULL default NULL on update CURRENT_TIMESTAMP,
  `date_created` datetime NOT NULL,
  `is_deleted` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`source_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `spider_event`
--

DROP TABLE IF EXISTS `spider_event`;
CREATE TABLE `spider_event` (
  `spider_event_id` int(11) NOT NULL,
  `source_id` int(11) NOT NULL,
  `raw_rss_id` int(11) NOT NULL,
  `spider_status_id` int(11) NOT NULL,
  `date_created` datetime default NULL,
  `date_modified` timestamp NULL default NULL on update CURRENT_TIMESTAMP,
  `is_deleted` tinyint(1) NOT NULL,
  KEY `spider_event_id` (`spider_event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `spider_status`
--

DROP TABLE IF EXISTS `spider_status`;
CREATE TABLE `spider_status` (
  `spider_status_id` int(11) NOT NULL auto_increment,
  `spider_status` varchar(255) NOT NULL,
  PRIMARY KEY  (`spider_status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;
