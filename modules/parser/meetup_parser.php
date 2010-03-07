#!/usr/bin/env php
<?php
include(dirname(dirname(dirname(__FILE__))) . '/config/application.php');

$rawRsses = RawRss_Collection::getUnimportedRssBySourceGroupId(SourceGroup::MEETUP_SOURCE_GROUP_ID);

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
		$source = $rawRss->getSource_Object();
		$event->setSourceId($source->getSourceId());
		$event->setCityId($source->getCityId());
		$event->setGuid(trim($item->get_id()));
		
		$name = html_entity_decode($item->get_title());
		$dateSeparator = ': ';
		$pos = strpos($name, $dateSeparator);
		if ($pos !== false)
		{
			$name = substr($name, $pos + strlen($dateSeparator));
		}
		
		$event->setName($name);
		$event->setDescription(html_entity_decode($item->get_description()));
		$event->setDate(date('Y-m-d H:i:s', Ev_Date::stringToDateTime(html_entity_decode($item->get_description()))));
		$event->setDatePublished(date('Y-m-d H:i:s', strtotime($item->get_date())));
		$event->setLink($item->get_link());
		
		$events->add($event);
		$seenGuids[$event->getGuid()] = true;
	}
	
	$rawRss->setIsImported(1);
}

$events->save();
$rawRsses->save();
