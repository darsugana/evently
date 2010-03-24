CREATE TABLE `evently`.`user` (
`user_id` INT NOT NULL AUTO_INCREMENT ,
`facebook_uid` BIGINT NULL ,
`is_deleted` TINYINT( 1 ) NOT NULL ,
`date_created` DATETIME NULL DEFAULT NULL ,
`date_modified` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NULL DEFAULT NULL ,
PRIMARY KEY ( `user_id` )
) ENGINE = InnoDB;
CREATE TABLE `evently`.`event_vote` (
`event_vote_id` INT(11) NOT NULL AUTO_INCREMENT ,
`event_id` INT(11) NOT NULL ,
`user_id` INT(11) NULL ,
`value` INT(11) NOT NULL ,
`is_deleted` TINYINT(1) NOT NULL ,
`date_created` DATETIME NULL DEFAULT NULL ,
`date_modified` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NULL DEFAULT NULL ,
PRIMARY KEY ( `event_vote_id` )
) ENGINE = InnoDB;
ALTER TABLE `event` ADD `vote_total` INT NOT NULL AFTER `city_id` ;
