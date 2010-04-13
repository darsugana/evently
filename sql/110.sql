USE `evently`;

CREATE TABLE IF NOT EXISTS `venue_location` (
  `venue_location_id` int(11) NOT NULL auto_increment,
  `venue_id` int(11) NOT NULL,
  `latitude` float NOT NULL,
  `longitude` float NOT NULL,
  `location` geometry NOT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  `date_created` datetime default NULL,
  `date_modified` timestamp NULL default NULL on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`venue_location_id`),
  SPATIAL KEY `location` (`location`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='MyISAM is dumb';

INSERT INTO venue_location(venue_id, latitude, longitude, location, date_created)
SELECT
	venue_id,
	latitude,
	longitude,
	GeomFromWKB(POINT(latitude, longitude)),	
	NOW()
FROM
	venue
WHERE
	is_deleted = 0
	AND latitude IS NOT NULL;
	
