#!/usr/bin/env php
<?php
include(dirname(dirname(dirname(__FILE__))) . '/config/application.php');

$rawRss = new RawRss();
$rawRssData = file_get_contents('http://upcoming.yahoo.com/syndicate/v2/search_all/?loc=Austin&rt=1');
preg_match('/lastBuildDate\>(.*)\<\/lastBuildDate/', $rawRssData, $matches);
$lastBuildDate = date('Y-m-d H:i:s', strtotime($matches[1]));

// check if we have this build of the rss feed yet
$recentRawRss = RawRss::constructByKey(array(
	'source_id' => Source::UPCOMING_SOURCE_ID,
	'last_build_date' => $lastBuildDate,
	'is_deleted' => false
));

// only save if this is a new build of the feed
if (!is_object($recentRawRss))
{
	$rawRss->setRawRssData($rawRssData);
	$rawRss->setLastBuildDate($lastBuildDate);
	$rawRss->setSourceId(Source::UPCOMING_SOURCE_ID);
	$rawRss->setDateCreated(date('Y-m-d H:i:s', CURRENT_TIMESTAMP));
	$rawRss->save();
}
?>