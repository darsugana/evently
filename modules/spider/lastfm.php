#!/usr/bin/env php
<?php
include(dirname(dirname(dirname(__FILE__))) . '/config/application.php');

$spiderEvents = new SpiderEvent_Collection();

$rawRss = new RawRss();
$rawRssData = file_get_contents('http://ws.audioscrobbler.com/2.0/geo/austin/events.rss');
$spiderEvents->add(SpiderEvent::buildBySourceAndStatusId(Source::LASTFM_SOURCE_ID, SpiderStatus::ATTEMPTED_CONNECTION_STATUS_ID));

preg_match('/generator\>(.*)\<\/generator/', $rawRssData, $matches);

// if we can't find a generator, there probably isn't a feed there
if (empty($matches))
{
	$spiderEvents->add(SpiderEvent::buildBySourceAndStatusId(Source::LASTFM_SOURCE_ID, SpiderStatus::NO_FEED_FOUND_STATUS_ID));
}
else
{
	// check if we have this build of the rss feed yet
	$recentRawRss = RawRss::constructByKey(array(
		'source_id' => Source::LASTFM_SOURCE_ID,
		'raw_rss_data' => $rawRssData,
		'is_deleted' => false,
	));
	
	// only save if this is a new build of the feed
	if (is_object($recentRawRss))
	{
		$spiderEvents->add(SpiderEvent::buildBySourceAndStatusId(Source::LASTFM_SOURCE_ID, SpiderStatus::DISCARDED_RAW_RSS_STATUS_ID));
	}
	else
	{
		$rawRss->setRawRssData($rawRssData);
		$rawRss->setLastBuildDate(date('Y-m-d H:i:s', CURRENT_TIMESTAMP));
		$rawRss->setSourceId(Source::LASTFM_SOURCE_ID);
		$rawRss->setDateCreated(date('Y-m-d H:i:s', CURRENT_TIMESTAMP));
		if ($rawRss->save())
		{
			$spiderEvents->add(SpiderEvent::buildBySourceAndStatusId(Source::LASTFM_SOURCE_ID, SpiderStatus::SAVED_NEW_RSS_STATUS_ID));
			foreach ($spiderEvents as $spiderEvent)
			{
				$spiderEvent->setRawRssId($rawRss->getRawRssId());
			}
		}
	}
}

$spiderEvents->save();
?>
