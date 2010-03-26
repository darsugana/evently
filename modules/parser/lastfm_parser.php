#!/usr/bin/env php
<?php
include(dirname(dirname(dirname(__FILE__))) . '/config/application.php');

define('XCAL_NAMESPACE', 'urn:ietf:params:xml:ns:xcal');

$rawRsses = RawRss_Collection::getUnimportedRssBySourceGroupId(SourceGroup::LASTFM_SOURCE_GROUP_ID);

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
		$dateSeparator = ' on ';
		$pos = strpos($name, $dateSeparator);
		if ($pos !== false)
		{
			$name = substr($name, 0, $pos);
		}
		
		$description = $item->get_description();
		$descriptionLines = explode("\n", $description);
		$firstLine = $descriptionLines[0];
		$venueName = html_entity_decode(trim(str_replace('Location: ', '', $firstLine)));
		unset($descriptionLines[0]);
		unset($descriptionLines[1]);
		$description = html_entity_decode(implode("\n", $descriptionLines));
		
		$event->setName($name);
		$event->setDescription($description);
		$event->setDate(date('Y-m-d H:i:s', strtotime($item->get_date())));
		$event->setDatePublished($event->getDate());
		$event->setLink($item->get_link());
		
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
		
		$venueTag = array_pop($item->get_item_tags(XCAL_NAMESPACE, 'location'));
		if (!empty($venueTag) && isset($venueTag['data']) && !empty($venueTag['data']))
		{
			$venueGuid = $venueTag['data'];
			// TODO: hook into last.fm venue API and get info
			$venue = Venue::constructByGuid($venueGuid);
			if (!is_object($venue))
			{
				$venue = new Venue();
				$venue->setGuid($venueGuid);
				$venue->setName($venueName);
				$venue->setDateCreated($now);
				$venue->setUrl($venueGuid);
				$venue->save();
			}
			$event->setVenueId($venue->getKeyId());
		}
		
		$event->save();
		
		$summarizer = new Ev_Summarizer();

		$text = $event->getName() . "\n" . strip_tags($event->getDescription());
		$summaryText = $summarizer->summarize($text);
		$tags = $summarizer->getUnstemmedKeywords();

		$i = 0;
		foreach ($tags as $tagName => $count)
		{
			if ($i++ > 5)
			{
				break;
			}
			$tag = Tag_Collection::getTagByName($tagName, true);
			$tag2Event = new Tag2event();
			$tag2Event->setTagId($tag->getKeyId());
			$tag2Event->setEventId($event->getKeyId());
			$tag2Event->save();
		}
	
		
		$events->add($event);
		$seenGuids[$event->getGuid()] = true;
	}

	$rawRss->setIsImported(1);

	
}

$events->save();
$rawRsses->save();

?>
