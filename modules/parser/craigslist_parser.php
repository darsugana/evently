#!/usr/bin/env php
<?php
include(dirname(dirname(dirname(__FILE__))) . '/config/application.php');


$rawRsses = RawRss_Collection::getUnimportedRssBySourceGroupId(SourceGroup::CRAIGSLIST_SOURCE_GROUP_ID);

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
		
		$name = trim(html_entity_decode($item->get_title()));

		$event->setName($name);
		$event->setDescription(trim(html_entity_decode($item->get_description())));
		$event->setDate(date('Y-m-d H:i:s', strtotime($item->get_date())));
		$event->setDatePublished($event->getDate());
		$event->setLink($item->get_link());
		
		$event->setDateCreated($now);

		$date = Ev_Date::stringToDateTimeArray($event->getName());
		if ($date['date'] !== false)
		{
			if ($date['has_time'])
			{
				$event->setDate(date('Y-m-d H:i:s',$date['time']));
			}
			else
			{
				$event->setDate(date('Y-m-d H:i:s',$date['date']));
			}
			$event->setAllDayEvent(!$date['has_time']);
		}
		else 
		{
			$date = Ev_Date::stringToDateTimeArray($event->getDescription());
			if ($date['date'] !== false)
			{
				if ($date['has_time'])
				{
					$event->setDate(date('Y-m-d H:i:s',$date['time']));
				}
				else
				{
					$event->setDate(date('Y-m-d H:i:s',$date['date']));
				}
				$event->setAllDayEvent(!$date['has_time']);
			}
		}
		$event->save();
		$events->add($event);
		
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
		
		
		// TODO:
		// 1) Parse out freetext dates
		// 2) Trim/tidy descriptions
		// 3) Guess at locations
	}

	$rawRss->setIsImported(1);

	
}


$events->save();
$rawRsses->save();

?>
