CREATE TABLE  `evently`.`tag` (
`tag_id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`name` VARCHAR( 255 ) NOT NULL ,
`date_created` DATETIME NOT NULL ,
`date_modified` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NULL ,
`is_deleted` BOOL NOT NULL
) ENGINE = INNODB

CREATE TABLE  `evently`.`tag2event` (
`tag_event_id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`tag_id` INT( 11 ) NOT NULL ,
`event_id` INT( 11 ) NOT NULL ,
`date_created` DATETIME NOT NULL ,
`date_modified` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NULL ,
`is_deleted` BOOL NOT NULL DEFAULT  '0'
) ENGINE = INNODB

CREATE TABLE  `evently`.`tag2venue` (
`tag_venue_id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`tag_id` INT( 11 ) NOT NULL ,
`venue_id` INT( 11 ) NOT NULL ,
`date_created` DATETIME NOT NULL ,
`date_modified` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NULL ,
`is_deleted` BOOL NOT NULL DEFAULT  '0'
) ENGINE = INNODB

CREATE TABLE  `evently`.`tag2source` (
`tag_source_id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`tag_id` INT( 11 ) NOT NULL ,
`source_id` INT( 11 ) NOT NULL ,
`date_created` DATETIME NOT NULL ,
`date_modified` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NULL ,
`is_deleted` BOOL NOT NULL DEFAULT  '0'
) ENGINE = INNODB
