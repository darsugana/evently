#!/usr/bin/env php
<?php
include(dirname(dirname(dirname(__FILE__))) . '/config/application.php');

define('XCAL_NAMESPACE', 'urn:ietf:params:xml:ns:xcal');

$rawRsses = RawRss_Collection::getUnimportedRssBySourceId(Source::LASTFM_SOURCE_ID);

$events = new Event_Collection();

$seenGuids = array();
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
		if (is_object($event) || isset($seenGuids[trim($item->get_id())]))
		{
			// TODO update event
			continue;
		}
		$event = new Event();
		$event->setRawRssId($rawRss->getKeyId());
		$event->setSourceId(Source::LASTFM_SOURCE_ID);
		$event->setGuid(trim($item->get_id()));
		
		$name = $item->get_title();
		$dateSeparator = ' on ';
		$pos = strpos($name, $dateSeparator);
		if ($pos !== false)
		{
			$name = substr($name, $pos + strlen($dateSeparator));
		}
		
		$event->setName($name);
		$event->setDescription($item->get_description());
		$event->setDate(date('Y-m-d H:i:s', strtotime($item->get_date())));
		$event->setDatePublished($event->getDate());
		$event->setLink($item->get_link());
		$event->setLatitude($item->get_latitude());
		$event->setLongitude($item->get_longitude());

		$event->setDateCreated($now);
		
		$dates = $item->get_item_tags(XCAL_NAMESPACE, 'dtstart');
		
		if (is_array($dates))
		{
			foreach ($dates as $dateArray)
			{
				$date = $dateArray['data'];
				$date = str_replace('T', ' ', $date);
				$timestamp = strtotime($date);
				$event->setDate(date('Y-m-d H:i:s', $timestamp));
			}
		}
		
		$venueLink = $item->get_item_tags(XCAL_NAMESPACE, 'location');
		
		if (!empty($venueLink))
		{
			// TODO: hook into last.fm venue API and get info
		}
		
		$events->add($event);
		$seenGuids[$event->getGuid()] = true;
	}

	$rawRss->setIsImported(1);

	
}


$events->save();
$rawRsses->save();

?>
