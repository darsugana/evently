USE `evently`;
CREATE TABLE `evently`.`category` (
`category_id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
`name` VARCHAR( 255 ) NOT NULL ,
`is_deleted` TINYINT( 1 ) NOT NULL ,
`date_created` DATETIME NULL ,
`date_modified` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NULL ,
PRIMARY KEY ( `category_id` )
) ENGINE = InnoDB;

INSERT INTO `category` (`category_id`, `name`, `is_deleted`, `date_created`, `date_modified`) VALUES
(1, 'Music', 0, NULL, NULL),
(2, 'Movie', 0, NULL, NULL),
(3, 'TV', 0, NULL, NULL),
(4, 'Lecture', 0, NULL, NULL),
(5, 'Meetup', 0, NULL, NULL);
ALTER TABLE `event` ADD `category_id` INT( 11 ) NULL AFTER `city_id` 