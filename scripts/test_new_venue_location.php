#!/usr/bin/env php
<?php
include(dirname(dirname(__FILE__)) . '/config/application.php');

// test new venue
$venue = new Venue();
$venue->setName("Justine's");
$venue->setLatitude(30.3767);
$venue->setLongitude(-97.7592);
$venue->save();

$venueLocation = VenueLocation::constructByKey(array(
	'venue_id' => $venue->getVenueId()
));

print_r($venueLocation->getFields());

sleep(70);

$venue->setLongitude(49.444);
$venue->save();

$venueLocation = VenueLocation::constructByKey(array(
	'venue_id' => $venue->getVenueId()
));

print_r($venueLocation->getFields());
