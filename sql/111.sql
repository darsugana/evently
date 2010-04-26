ALTER TABLE  `venue_location` DROP  `is_deleted`;
CREATE UNIQUE INDEX `venue_id` ON `venue_location` (`venue_id`);