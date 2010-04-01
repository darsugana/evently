USE `evently`;
CREATE TABLE `evently`.`rsvp` (
`rsvp_id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
`user_id` INT( 11 ) NOT NULL ,
`event_id` INT( 11 ) NOT NULL ,
`is_deleted` TINYINT( 1 ) NOT NULL ,
`date_created` DATETIME NULL ,
`date_modified` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NULL ,
PRIMARY KEY ( `rsvp_id` )
) ENGINE = InnoDB;
ALTER TABLE `event` ADD `rsvp_total` INT( 11 ) NOT NULL AFTER `vote_total` ;