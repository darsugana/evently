use `evently`;
CREATE TABLE `evently`.`city` (
`city_id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`short_name` VARCHAR( 3 ) NOT NULL ,
`long_name` VARCHAR( 31 ) NOT NULL ,
`state` VARCHAR( 2 ) NOT NULL ,
`date_created` DATETIME NULL DEFAULT NULL ,
`date_modified` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NULL DEFAULT NULL ,
`is_deleted` TINYINT( 1 ) NOT NULL ,
INDEX ( `short_name` )
) ENGINE = InnoDB;


INSERT INTO `city` (`city_id`, `short_name`, `long_name`, `state`, `date_created`, `date_modified`, `is_deleted`) VALUES
(1, 'atx', 'Austin', 'TX', '2009-04-02 20:33:00', NULL, 0),
(2, 'nyc', 'New York', 'NY', '2009-04-02 20:33:00', NULL, 0),
(3, 'sfc', 'San Francisco', 'CA', '2009-04-02 20:33:51', NULL, 0);

CREATE TABLE `evently`.`source_group` (
`source_group_id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`name` VARCHAR( 31 ) NOT NULL ,
`date_created` DATETIME NULL DEFAULT NULL ,
`date_modified` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NULL DEFAULT NULL ,
`is_deleted` TINYINT( 1 ) NOT NULL
) ENGINE = InnoDB;

ALTER TABLE `source` ADD `city_id` INT( 11 ) NULL DEFAULT NULL AFTER `feed` ,
ADD `source_group_id` INT( 11 ) NULL DEFAULT NULL AFTER `city_id` ,
ADD INDEX ( source_group_id );

ALTER TABLE `event` ADD `city_id` INT( 11 ) NULL DEFAULT NULL AFTER `venue_id`;


INSERT INTO `source_group` (`source_group_id`, `name`, `date_created`, `date_modified`,`is_deleted`) VALUES
(1, 'Upcoming', 	   NOW(), NULL, 0),
(2, 'Craigslist', 	   NOW(), NULL, 0),
(3, 'Showlist Austin', NOW(), NULL, 0),
(4, 'Last.fm', 		   NOW(), NULL, 0),
(5, 'Linkedin', 	   NOW(), NULL, 0);

UPDATE source SET source_group_id = source_id, city_id = 1;


INSERT INTO `source` (`name`, `feed`, `city_id`, `source_group_id`, `date_modified`, `date_created`, `is_deleted`) VALUES
('Upcoming', 'http://upcoming.yahoo.com/syndicate/v2/search_all/?search_placeid=hVUWVhqbBZlZSrZU&rt=1', 2, 1, NULL, NOW(), 0),
('Craigslist', 'http://nyc.craigslist.org/eve/index.rss', 2, 2, NULL, NOW(), 0),
('Last.fm', 'http://ws.audioscrobbler.com/2.0/geo/new+york/events.rss', 2, 4, NULL, NOW(), 0),
('Linkedin', 'http://events.linkedin.com/greater-new-york-city-area', 2, 5, NULL, NOW(), 0),

('Upcoming', 'http://upcoming.yahoo.com/syndicate/v2/search_all/?search_placeid=YP2B0HibApl1IcIVWg--&rt=1', 3, 1, NULL, NOW(), 0),
('Craigslist', 'http://sfbay.craigslist.org/eve/index.rss', 3, 2, NULL, NOW(), 0),
('Last.fm', 'http://ws.audioscrobbler.com/2.0/geo/san+francisco/events.rss', 3, 4, NULL, NOW(), 0),
('Linkedin', 'http://events.linkedin.com/san-francisco-bay-area', 3, 5, NULL, NOW(), 0);

UPDATE `evently`.`source` SET `feed` = 'http://ws.audioscrobbler.com/2.0/geo/events.rss?location=Austin' WHERE `source`.`source_id` =4 LIMIT 1 ;

UPDATE `evently`.`source` SET `feed` = 'http://ws.audioscrobbler.com/2.0/geo/events.rss?location=New+York' WHERE `source`.`source_id` =8 LIMIT 1 ;

UPDATE `evently`.`source` SET `feed` = 'http://ws.audioscrobbler.com/2.0/geo/events.rss?location=San+Francisco' WHERE `source`.`source_id` =12 LIMIT 1 ;


