#!/usr/bin/env php
<?php
include(dirname(dirname(dirname(__FILE__))) . '/config/application.php');


$rawRsses = RawRss_Collection::getUnimportedRssBySourceId(Source::CRAIGSLIST_SOURCE_ID);

$events = new Event_Collection();

$now = date('Y-m-d H:i:s');

foreach ($rawRsses as $rawRss)
{
	echo 'importing ' . $rawRss->getKeyId() . "\n";
	$feed = new SimplePie();
	$feed->set_raw_data($rawRss->getRawRssData());
	$feed->enable_cache(false);
	$feed->init();

	$items = $feed->get_items();

	foreach ($items as $item)
	{
		// var_dump($item->get_title());
		// var_dump($item);
		
		// FIXME TODO RHP 2009-02-08 queries in loops :(
		$event = Event::constructByGuid(trim($item->get_id()));
		if (is_object($event))
		{
			// TODO update event
			// continue;
		}
		$event = new Event();
		$event->setRawRssId($rawRss->getKeyId());
		$event->setSourceId(Source::CRAIGSLIST_SOURCE_ID);
		$event->setGuid(trim($item->get_id()));
		
		$name = $item->get_title();

		$event->setName($name);
		$event->setDescription($item->get_description());
		$event->setDate(date('Y-m-d H:i:s', strtotime($item->get_date())));
		$event->setDatePublished($event->getDate());
		$event->setLink($item->get_link());
		
		$event->setDateCreated($now);
		
		$events->add($event);
		
		Ev_Date::stringToDate($event->getDescription);
		
		// TODO:
		// 1) Parse out freetext dates
		// 2) Trim/tidy descriptions
		// 3) Guess at locations
	}

	// $rawRss->setIsImported(1);

	
}


// $events->save();
$rawRsses->save();

?>