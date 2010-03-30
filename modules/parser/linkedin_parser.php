#!/usr/bin/env php
<?php
include(dirname(dirname(dirname(__FILE__))) . '/config/application.php');


$rawHtmls = RawHtml_Collection::getUnimportedHtmlBySourceGroupId(SourceGroup::LINKEDIN_SOURCE_GROUP_ID);

$events = new Event_Collection();

$now = date('Y-m-d H:i:s');

foreach ($rawHtmls as $rawHtml)
{
	echo 'importing ' . $rawHtml->getKeyId() . "\n";
	
	$html = str_get_html($rawHtml->getRawHtmlData());
	$nodes = $html->find('div[id=browse-events]', 0)->children();
	foreach ($nodes as $node)
	{
		$date = $now;
		if ($node->tag == 'div' && $node->class == 'vevent event')
		{
			$dateNode = $node->find('abbr[class=dtstart]',0);
			if (is_object($dateNode))
			{
				$date = Ev_Date::stringToDateTime($dateNode->title);
			}
			// $guid = $node->id;
			$summaryLinkNode = $node->find('h3[class=summary]',0)->find('a',0);
			$link = $summaryLinkNode->href;
			$guid = $link;
			$name = trim($summaryLinkNode->plaintext);
		
			$venueNode = $node->find('dd[class=location]',0);
			$venueRawName = $venueNode->plaintext;
			$venueName = $venueRawName;
			
			$venueArray = explode(',', $venueRawName);
			if ($venueArray !== FALSE)
			{
				$venueName = $venueArray[0];
			}

			$event = Event::constructByGuid($guid);
			if (is_object($event))
			{
				// TODO update event
				continue;
			}
		
			$event = new Event();
			$event->setRawHtmlId($rawHtml->getKeyId());

			$source = $rawHtml->getSource_Object();
			$event->setSourceId($source->getSourceId());
			$event->setCityId($source->getCityId());

			$event->setGuid($guid);
			
			
			$event->setName(Ev_String::wordTrim($name, 255));
			$event->setDescription($name);
			$event->setDate($now);
			$event->setDatePublished($now);
			$event->setLink($link);
			
			$event->setDateCreated($now);
		

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

			$venue = Venue::constructByName($venueName);
			if (is_object($venue))
			{
				$event->setVenueId($venue->getKeyId());
			}
			else
			{
				// create venue
			}
			
			$event->setCategoryId(Category::LECTURE);
			
			$event->save();
			
			// tags
			$tagNodes = $node->find('dd[class=tags]');
			foreach ($tagNodes as $tagNode)
			{
				$tagName = rtrim(trim($tagNode->plaintext),',');
				$tag = Tag_Collection::getTagByName($tagName, true);
				$tag2Event = new Tag2event();
				$tag2Event->setTagId($tag->getKeyId());
				$tag2Event->setEventId($event->getKeyId());
				$tag2Event->save();
			}
			
			
			
		}
		
		
	}

	$html->clear();
	$html = null;
	

	$rawHtml->setIsImported(1);
}


$rawHtmls->save();

?>
