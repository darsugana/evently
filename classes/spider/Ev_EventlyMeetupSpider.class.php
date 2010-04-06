<?php

class Ev_EventlyMeetupSpider extends Ev_EventlyAbstractSpider
{
	
	private $timestamp = '';
	
	
	public function isValid($data)
	{
		
		$matches = array();
		preg_match('/lastBuildDate\>(.*)\<\/lastBuildDate/', $data, $matches);
		
		if (count($matches))
		{
			$this->timestamp = strtotime($matches[1]);
		}
		return !empty($matches);
	}
	
	public function isNew($rawRssData, $source)
	{
		$lastBuildDate = date('Y-m-d H:i:s', $this->timestamp);

		// check if we have this build of the rss feed yet
		$recentRawRss = RawRss::constructByKey(array(
			'source_id' => $source->getSourceId(),
			'last_build_date' => $lastBuildDate,
			'is_deleted' => false
		));
		
		return is_null($recentRawRss);
		
	}
	
	
	public function getNewDataObject()
	{
		return new RawRss();
	}
	
	public function setRawObjectFields(&$rawDataObject, &$rawData, $source)
	{

		$lastBuildDate = date('Y-m-d H:i:s', $this->timestamp);
		
	
		$rawDataObject->setRawRssData($rawData);
		$rawDataObject->setLastBuildDate($lastBuildDate);
		$rawDataObject->setSourceId($source->getSourceId());
		$rawDataObject->setDateCreated(date('Y-m-d H:i:s', CURRENT_TIMESTAMP));
		
		return $rawDataObject;
		
	}
	
	public function spider()
	{
		parent::spider(SourceGroup::MEETUP_SOURCE_GROUP_ID);
	}
	
}
