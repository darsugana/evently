#!/usr/bin/env php
<?php
include(dirname(dirname(dirname(__FILE__))) . '/config/application.php');


$rawHtmls = RawHtml_Collection::getUnimportedHtmlBySourceGroupId(SourceGroup::SHOWLISTAUSTIN_SOURCE_GROUP_ID);

$events = new Event_Collection();
$seenGuids = array();

$now = date('Y-m-d H:i:s');

foreach ($rawHtmls as $rawHtml)
{
	echo 'importing ' . $rawHtml->getKeyId() . "\n";
	
	$html = str_get_html($rawHtml->getRawHtmlData());
	// echo $doc->saveHTML();
	$nodes = $html->find('ul', 0)->children();
	foreach ($nodes as $node)
	{
		$date = $now;
		foreach ($node->children() as $childNode)
		{
			if ($childNode->tag == 'b')
			{
				$date = Ev_Date::stringToDate($childNode->plaintext);
			}
			else if ($childNode->tag == 'ul')
			{
				foreach ($childNode->children() as $item)
				{
					if ($item->tag == 'hr')
					{
						continue;
					}

					$name = trim($item->plaintext);
					$name = html_entity_decode(str_replace('[+]', '', $name));
					
					$link = trim($item->find('a', 0)->href);
					$venueName = html_entity_decode($item->find('a', 0)->plaintext);
					
					if (strpos($link, 'cgi/genpage.cgi?venue=') !== false)
					{
						$link = '';
						$venueName = '';
					}
					
					$guid = $name . ' ' . $link . ' ' . $date; 
					$guid = substr($guid, 0, 255);
					
					$event = Event::constructByGuid($guid);
					if (is_object($event) || isset($seenGuids[$guid]))
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
				

					if ($date !== false)
					{
						$event->setDate(date('Y-m-d H:i:s',$date));
					}

					$venue = Venue::constructByName($venueName);
					if (is_object($venue))
					{
						$event->setVenueId($venue->getKeyId());
					}

					$events->add($event);
					
					$seenGuids[$event->getGuid()] = true;
				
				}
			}
		}
	}

	$html->clear();
	$html = null;
	

	$rawHtml->setIsImported(1);
}


$events->save();
$rawHtmls->save();

?>
