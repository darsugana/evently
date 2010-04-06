<?php

class Ev_EventlyLastFmSpider extends Ev_EventlyAbstractSpider
{
	
	
	public function isValid($data)
	{
		
		$matches = array();
		preg_match('/generator\>(.*)\<\/generator/', $data, $matches);

		return !empty($matches);
	}
	
	public function isNew($rawRssData, $source)
	{
		// check if we have this build of the rss feed yet
		$recentRawRss = RawRss::constructByKey(array(
			'source_id' => $source->getSourceId(),
			'raw_rss_data' => $rawRssData,
			'is_deleted' => false,
		));
		
		return is_null($recentRawRss);
		
	}
	
	
	public function getNewDataObject()
	{
		return new RawRss();
	}
	
	public function setRawObjectFields(&$rawDataObject, &$rawData, $source)
	{

		$rawDataObject->setRawRssData($rawData);
		$rawDataObject->setLastBuildDate(date('Y-m-d H:i:s', CURRENT_TIMESTAMP));
		$rawDataObject->setSourceId($source->getSourceId());
		$rawDataObject->setDateCreated(date('Y-m-d H:i:s', CURRENT_TIMESTAMP));
		
		return $rawDataObject;
		
	}
	
	public function spider()
	{
		parent::spider(SourceGroup::LASTFM_SOURCE_GROUP_ID);
	}
	
}
