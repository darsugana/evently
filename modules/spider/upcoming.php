#!/usr/bin/env php
<?php
include(dirname(dirname(dirname(__FILE__))) . '/config/application.php');

$spiderEvents = new SpiderEvent_Collection();

$rawRss = new RawRss();
$rawRssData = file_get_contents('http://upcoming.yahoo.com/syndicate/v2/search_all/?loc=Austin&rt=1');
$spiderEvents->add(SpiderEvent::buildBySourceAndStatusId(Source::UPCOMING_SOURCE_ID, SpiderStatus::ATTEMPTED_CONNECTION_STATUS_ID));

preg_match('/lastBuildDate\>(.*)\<\/lastBuildDate/', $rawRssData, $matches);

// if we can't find a lastBuildDate, there probably isn't a feed there
if (empty($matches))
{
	$spiderEvents->add(SpiderEvent::buildBySourceAndStatusId(Source::UPCOMING_SOURCE_ID, SpiderStatus::NO_FEED_FOUND_STATUS_ID));
}
else
{
	$lastBuildDate = date('Y-m-d H:i:s', strtotime($matches[1]));
	
	// check if we have this build of the rss feed yet
	$recentRawRss = RawRss::constructByKey(array(
		'source_id' => Source::UPCOMING_SOURCE_ID,
		'last_build_date' => $lastBuildDate,
		'is_deleted' => false
	));
	
	// only save if this is a new build of the feed
	if (is_object($recentRawRss))
	{
		$spiderEvents->add(SpiderEvent::buildBySourceAndStatusId(Source::UPCOMING_SOURCE_ID, SpiderStatus::DISCARDED_RAW_RSS_STATUS_ID));
	}
	else
	{
		$rawRss->setRawRssData($rawRssData);
		$rawRss->setLastBuildDate($lastBuildDate);
		$rawRss->setSourceId(Source::UPCOMING_SOURCE_ID);
		$rawRss->setDateCreated(date('Y-m-d H:i:s', CURRENT_TIMESTAMP));
		if ($rawRss->save())
		{
			$spiderEvents->add(SpiderEvent::buildBySourceAndStatusId(Source::UPCOMING_SOURCE_ID, SpiderStatus::SAVED_NEW_RSS_STATUS_ID));
			foreach ($spiderEvents as $spiderEvent)
			{
				$spiderEvent->setRawRssId($rawRss->getRawRssId());
			}
		}
	}
}

$spiderEvents->save();
?>