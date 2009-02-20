-- MySQL dump 10.11
--
-- Host: localhost    Database: evently
-- ------------------------------------------------------
-- Server version	5.0.67

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `event`
--

DROP TABLE IF EXISTS `event`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `event` (
  `event_id` int(11) NOT NULL auto_increment,
  `source_id` int(11) NOT NULL,
  `raw_rss_id` int(11) NOT NULL,
  `raw_html_id` int(11) default NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date` datetime NOT NULL,
  `guid` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `latitude` float default NULL,
  `longitude` float default NULL,
  `venue_id` int(11) default NULL,
  `date_published` datetime NOT NULL,
  `date_modified` timestamp NULL default NULL on update CURRENT_TIMESTAMP,
  `date_created` datetime NOT NULL,
  `is_deleted` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `event`
--

LOCK TABLES `event` WRITE;
/*!40000 ALTER TABLE `event` DISABLE KEYS */;
/*!40000 ALTER TABLE `event` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `raw_html`
--

DROP TABLE IF EXISTS `raw_html`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `raw_html` (
  `raw_html_id` int(11) NOT NULL auto_increment,
  `source_id` int(11) NOT NULL,
  `raw_html_data` mediumtext,
  `raw_html_hash` varchar(256) default NULL,
  `is_imported` tinyint(1) NOT NULL default '0',
  `date_modified` timestamp NULL default NULL on update CURRENT_TIMESTAMP,
  `date_created` datetime default NULL,
  `is_deleted` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`raw_html_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `raw_html`
--

LOCK TABLES `raw_html` WRITE;
/*!40000 ALTER TABLE `raw_html` DISABLE KEYS */;
/*!40000 ALTER TABLE `raw_html` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `raw_rss`
--

DROP TABLE IF EXISTS `raw_rss`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `raw_rss` (
  `raw_rss_id` int(11) unsigned NOT NULL auto_increment,
  `source_id` int(11) NOT NULL,
  `raw_rss_data` mediumtext NOT NULL,
  `is_imported` tinyint(1) NOT NULL default '0',
  `last_build_date` datetime NOT NULL,
  `date_modified` timestamp NULL default NULL on update CURRENT_TIMESTAMP,
  `date_created` datetime default NULL,
  `is_deleted` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`raw_rss_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `raw_rss`
--

LOCK TABLES `raw_rss` WRITE;
/*!40000 ALTER TABLE `raw_rss` DISABLE KEYS */;
/*!40000 ALTER TABLE `raw_rss` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `source`
--

DROP TABLE IF EXISTS `source`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `source` (
  `source_id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `feed` varchar(255) NOT NULL,
  `date_modified` timestamp NULL default NULL on update CURRENT_TIMESTAMP,
  `date_created` datetime NOT NULL,
  `is_deleted` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`source_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `source`
--

LOCK TABLES `source` WRITE;
/*!40000 ALTER TABLE `source` DISABLE KEYS */;
INSERT INTO `source` VALUES (1,'Upcoming','http://upcoming.yahoo.com/syndicate/v2/search_all/?loc=Austin&rt=1',NULL,'2008-09-28 01:43:32',0),(2,'Craigslist','http://austin.craigslist.org/eve/index.rss',NULL,'2009-02-09 19:37:55',0),(3,'Showlist Austin','http://showlistaustin.com',NULL,'2009-02-20 06:50:44',0);
/*!40000 ALTER TABLE `source` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `spider_event`
--

DROP TABLE IF EXISTS `spider_event`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `spider_event` (
  `spider_event_id` int(11) NOT NULL auto_increment,
  `source_id` int(11) NOT NULL,
  `raw_rss_id` int(11) default NULL,
  `raw_html_id` int(11) default NULL,
  `spider_status_id` int(11) NOT NULL,
  `date_created` datetime default NULL,
  `date_modified` timestamp NULL default NULL on update CURRENT_TIMESTAMP,
  `is_deleted` tinyint(1) NOT NULL,
  PRIMARY KEY  (`spider_event_id`),
  KEY `spider_event_id` (`spider_event_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `spider_event`
--

LOCK TABLES `spider_event` WRITE;
/*!40000 ALTER TABLE `spider_event` DISABLE KEYS */;
INSERT INTO `spider_event` VALUES (1,3,NULL,1,1,'2009-02-20 07:00:31',NULL,0),(2,3,NULL,1,2,'2009-02-20 07:00:31',NULL,0),(3,3,NULL,2,1,'2009-02-20 07:00:56',NULL,0),(4,3,NULL,2,2,'2009-02-20 07:00:56',NULL,0),(5,3,NULL,3,1,'2009-02-20 07:05:38',NULL,0),(6,3,NULL,3,2,'2009-02-20 07:05:38',NULL,0);
/*!40000 ALTER TABLE `spider_event` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `spider_status`
--

DROP TABLE IF EXISTS `spider_status`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `spider_status` (
  `spider_status_id` int(11) NOT NULL,
  `spider_status` varchar(255) NOT NULL,
  PRIMARY KEY  (`spider_status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `spider_status`
--

LOCK TABLES `spider_status` WRITE;
/*!40000 ALTER TABLE `spider_status` DISABLE KEYS */;
INSERT INTO `spider_status` VALUES (1,'attempted connection'),(2,'saved new raw rss'),(3,'discarded raw rss because lastBuildDate isn\'t new'),(4,'couldn\'t find a feed at url');
/*!40000 ALTER TABLE `spider_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `venue`
--

DROP TABLE IF EXISTS `venue`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `venue` (
  `venue_id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `description` text,
  `guid` varchar(255) default NULL,
  `street1` varchar(255) default NULL,
  `street2` varchar(255) default NULL,
  `state` varchar(31) default NULL,
  `zip_code` varchar(31) default NULL,
  `country` varchar(31) default NULL,
  `city` varchar(31) default NULL,
  `phone` varchar(31) default NULL,
  `url` varchar(255) default NULL,
  `latitude` float default NULL,
  `longitude` float default NULL,
  `date_modified` timestamp NULL default NULL,
  `date_created` datetime default NULL,
  `is_deleted` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`venue_id`),
  KEY `guid` (`guid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `venue`
--

LOCK TABLES `venue` WRITE;
/*!40000 ALTER TABLE `venue` DISABLE KEYS */;
/*!40000 ALTER TABLE `venue` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'evently'
--
DELIMITER ;;
DELIMITER ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2009-02-20 14:30:23
