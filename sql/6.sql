-- phpMyAdmin SQL Dump
-- version 3.0.0-rc1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 30, 2008 at 07:05 PM
-- Server version: 5.0.67
-- PHP Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `events`
--

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE IF NOT EXISTS `event` (
  `event_id` int(11) unsigned NOT NULL,
  `source_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `guid` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `date_published` datetime NOT NULL,
  `date_modified` timestamp NULL default NULL on update CURRENT_TIMESTAMP,
  `date_created` datetime NOT NULL,
  `is_deleted` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `event`
--


-- --------------------------------------------------------

--
-- Table structure for table `source`
--

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
