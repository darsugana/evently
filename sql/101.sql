INSERT INTO  `evently`.`source_group` (
`source_group_id` ,
`name` ,
`date_created` ,
`date_modified` ,
`is_deleted`
)
VALUES (
'6',  'Meetup', NOW( ) , NULL ,  '0'
);

INSERT INTO `evently`.`source` (`source_id`, `name`, `feed`, `city_id`, `source_group_id`, `date_modified`, `date_created`, `is_deleted`) VALUES ('14', 'Meetup', 'http://www.meetup.com/cities/us/tx/austin/rss/', '1', '6', NULL, NOW(), '0');

INSERT INTO `evently`.`source` (`source_id`, `name`, `feed`, `city_id`, `source_group_id`, `date_modified`, `date_created`, `is_deleted`) VALUES ('15', 'Meetup', 'http://www.meetup.com/cities/us/ny/new_york/rss/', '2', '6', NULL, NOW(), '0');

INSERT INTO `evently`.`source` (`source_id`, `name`, `feed`, `city_id`, `source_group_id`, `date_modified`, `date_created`, `is_deleted`) VALUES ('16', 'Meetup', 'http://www.meetup.com/cities/us/ca/san_francisco/rss/', '3', '6', NULL, NOW(), '0');