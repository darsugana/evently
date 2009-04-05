#!/usr/bin/env php
<?php
include(dirname(dirname(dirname(__FILE__))) . '/config/application.php');

$spiderEvents = new SpiderEvent_Collection();
$sources = Source_Collection::getSourcesBySourceGroupId(SourceGroup::LINKEDIN_SOURCE_GROUP_ID);

foreach ($sources as $source)
{

	$rawHtml = new RawHtml();
	$rawHtmlData = file_get_contents($source->getFeed());
	// $rawHtmlData = file_get_contents(dirname(__FILE__) . '/linkedin1.html');


	// linkedin assigns random event ids to the events each time you request the page, dunno why, but we don't want them.
	$htmlData = preg_replace("/id='#&lt;Event:0x[a-zA-z0-9]+&gt;'/",'', $rawHtmlData);

	$rawHtmlData = $htmlData;


	$spiderEvents->add(SpiderEvent::buildBySourceAndStatusId($source->getSourceId(), SpiderStatus::ATTEMPTED_CONNECTION_STATUS_ID));


	$hash = hash('sha256', $rawHtmlData);

	if (empty($hash))
	{
		$spiderEvents->add(SpiderEvent::buildBySourceAndStatusId($source->getSourceId(), SpiderStatus::NO_FEED_FOUND_STATUS_ID));
	}
	else
	{

		// check if we have this build of the rss feed yet
		$recentRawHtml = RawHtml::constructByKey(array(
			'source_id' => $source->getSourceId(),
			'raw_html_hash' => $hash,
			'is_deleted' => false
		));

		// only save if this is a new build of the feed
		if (is_object($recentRawHtml))
		{
			$spiderEvents->add(SpiderEvent::buildBySourceAndStatusId($source->getSourceId(), SpiderStatus::DISCARDED_RAW_RSS_STATUS_ID));
		}
		else
		{
			$rawHtml->setRawHtmlData($rawHtmlData);
			$rawHtml->setRawHtmlHash($hash);
			$rawHtml->setSourceId($source->getSourceId());
			$rawHtml->setDateCreated(date('Y-m-d H:i:s', CURRENT_TIMESTAMP));
			if ($rawHtml->save())
			{
				$spiderEvents->add(SpiderEvent::buildBySourceAndStatusId($source->getSourceId(), SpiderStatus::SAVED_NEW_RSS_STATUS_ID));
				foreach ($spiderEvents as $spiderEvent)
				{
					$spiderEvent->setRawHtmlId($rawHtml->getRawHtmlId());
				}
			}
		}
	}
}
$spiderEvents->save();
?>