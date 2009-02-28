#!/usr/bin/env php
<?php
include(dirname(dirname(dirname(__FILE__))) . '/config/application.php');


$rawHtmls = RawHtml_Collection::getUnimportedHtmlBySourceId(Source::LINKEDIN_SOURCE_ID);

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
			
			$venueArray = split(',', $venueRawName);
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
			$event->setSourceId(Source::LINKEDIN_SOURCE_ID);
			$event->setGuid($guid);
			
			
			$event->setName(Ev_String::wordTrim($name, 255));
			$event->setDescription($name);
			$event->setDate($now);
			$event->setDatePublished($now);
			$event->setLink($link);
			
			$event->setDateCreated($now);
		

			if ($date !== false)
			{
				$event->setDate(date('Y-m-d H:i:s',$date));
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

	$rawHtml->setIsImported(1);
}


$rawHtmls->save();

?>