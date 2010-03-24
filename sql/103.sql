-- phpMyAdmin SQL Dump
-- version 3.2.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 24, 2010 at 08:30 AM
-- Server version: 5.0.67
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
CREATE DATABASE IF NOT EXISTS `vogoo`;
USE `vogoo`;
--
-- Database: `vogoo`
--

-- --------------------------------------------------------

--
-- Table structure for table `vogoo_ads`
--

CREATE TABLE IF NOT EXISTS `vogoo_ads` (
  `ad_id` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `mini` int(11) NOT NULL,
  KEY `ad_id` (`ad_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vogoo_ads`
--


-- --------------------------------------------------------

--
-- Table structure for table `vogoo_ads_products`
--

CREATE TABLE IF NOT EXISTS `vogoo_ads_products` (
  `ad_id` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  KEY `ad_id` (`ad_id`),
  KEY `category` (`category`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vogoo_ads_products`
--


-- --------------------------------------------------------

--
-- Table structure for table `vogoo_links`
--

CREATE TABLE IF NOT EXISTS `vogoo_links` (
  `item_id1` int(11) NOT NULL,
  `item_id2` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `cnt` int(11) default NULL,
  `diff_slope` float default NULL,
  UNIQUE KEY `vogoo_links_ix` (`item_id1`,`item_id2`,`category`),
  KEY `vogoo_links_i1ix` (`item_id1`),
  KEY `vogoo_links_i2ix` (`item_id2`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vogoo_links`
--


-- --------------------------------------------------------

--
-- Table structure for table `vogoo_ratings`
--

CREATE TABLE IF NOT EXISTS `vogoo_ratings` (
  `member_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `rating` float NOT NULL,
  `ts` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  UNIQUE KEY `vogoo_ratings_mpix` (`member_id`,`product_id`,`category`),
  KEY `vogoo_ratings_mix` (`member_id`),
  KEY `vogoo_ratings_pix` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vogoo_ratings`
--

