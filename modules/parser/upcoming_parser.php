#!/usr/bin/env php
<?php
include(dirname(dirname(dirname(__FILE__))) . '/config/application.php');

define('XCAL_NAMESPACE', 'urn:ietf:params:xml:ns:xcal');

$rawRsses = RawRss_Collection::getUnimportedRssBySourceGroupId(SourceGroup::UPCOMING_SOURCE_GROUP_ID);

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
		
		$venueArray = $item->get_item_tags(XCAL_NAMESPACE, 'x-calconnect-venue');
		
		if (is_array($venueArray))
		{
			$venueArray = $venueArray[0];
			$children = $venueArray['child'][XCAL_NAMESPACE];
			$guid = $children['x-calconnect-venue-id'][0]['data'];
			
			// FIXME TODO RHP 2009-02-08 queries in loops :(
			$venue = Venue::constructByGuid($guid);
			if (!is_object($venue))
			{
				$venue = new Venue();
				$venue->setGuid($guid);
				$venue->setDateCreated($now);

				$venue->setUrl(trim($children['url'][0]['data']));
				$venue->setPhone(trim($children['x-calconnect-tel'][0]['data']));


				$adr = $children['adr'][0]['child'][XCAL_NAMESPACE];
				$venue->setName(trim(html_entity_decode($adr['x-calconnect-venue-name'][0]['data'])));
				$venue->setStreet1(trim($adr['x-calconnect-street'][0]['data']));
				$venue->setCity(trim($adr['x-calconnect-city'][0]['data']));
				$venue->setState(trim($adr['x-calconnect-region'][0]['data']));
				$venue->setZipCode(trim($adr['x-calconnect-postalcode'][0]['data']));
				$venue->setCountry(trim($adr['x-calconnect-country'][0]['data']));
				
				
				$venue->setLatitude($item->get_latitude());
				$venue->setLongitude($item->get_longitude());

				$venue->save();
			}
			$event->setVenueId($venue->getKeyId());
		}
		
		$events->add($event);
		$event->save();
		$seenGuids[$event->getGuid()] = true;
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
	
	}

	$rawRss->setIsImported(1);

	
}


$events->save();
$rawRsses->save();

?>
