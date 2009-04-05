#!/usr/bin/env php
<?php
include(dirname(dirname(dirname(__FILE__))) . '/config/application.php');

$spiderEvents = new SpiderEvent_Collection();

$sources = Source_Collection::getSourcesBySourceGroupId(SourceGroup::CRAIGSLIST_SOURCE_GROUP_ID);

foreach ($sources as $source)
{
	echo 'loading source: '. $source->getName() . " feed " . $source->getFeed() ."\n";
	$rawRss = new RawRss();
	$rawRssData = file_get_contents($source->getFeed());
	$spiderEvents->add(SpiderEvent::buildBySourceAndStatusId($source->getSourceId(), SpiderStatus::ATTEMPTED_CONNECTION_STATUS_ID));

	preg_match('/syn:updateBase\>(.*)\<\/syn:updateBase/', $rawRssData, $matches);

	$date = str_replace('T', ' ', $matches[1]);
	$timestamp = strtotime($date);

	// if we can't find a lastBuildDate, there probably isn't a feed there
	if (empty($matches))
	{
		$spiderEvents->add(SpiderEvent::buildBySourceAndStatusId($source->getSourceId(), SpiderStatus::NO_FEED_FOUND_STATUS_ID));
	}
	else
	{
		$lastBuildDate = date('Y-m-d H:i:s', $timestamp);
	
		// check if we have this build of the rss feed yet
		$recentRawRss = RawRss::constructByKey(array(
			'source_id' => $source->getSourceId(),
			'last_build_date' => $lastBuildDate,
			'is_deleted' => false
		));
	
		// only save if this is a new build of the feed
		if (is_object($recentRawRss))
		{
			$spiderEvents->add(SpiderEvent::buildBySourceAndStatusId($source->getSourceId(), SpiderStatus::DISCARDED_RAW_RSS_STATUS_ID));
		}
		else
		{
			$rawRss->setRawRssData($rawRssData);
			$rawRss->setLastBuildDate($lastBuildDate);
			$rawRss->setSourceId($source->getSourceId());
			$rawRss->setDateCreated(date('Y-m-d H:i:s', CURRENT_TIMESTAMP));
			if ($rawRss->save())
			{
				$spiderEvents->add(SpiderEvent::buildBySourceAndStatusId($source->getSourceId(), SpiderStatus::SAVED_NEW_RSS_STATUS_ID));
				foreach ($spiderEvents as $spiderEvent)
				{
					$spiderEvent->setRawRssId($rawRss->getRawRssId());
				}
			}
		}
	}
}
$spiderEvents->save();
?>