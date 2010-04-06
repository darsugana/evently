<?php

class Ev_EventlyLinkedinSpider extends Ev_EventlyAbstractSpider
{
	private $hash = '';
	
	public function preFilter($data)
	{
		return preg_replace("/id='#&lt;Event:0x[a-zA-z0-9]+&gt;'/",'', $data);
		;
	}
	
	public function isValid($data)
	{
		
		$this->hash = hash('sha256', $data);
		return !empty($this->hash);
	}
	
	public function isNew($data, $source)
	{
		// check if we have this build of the rss feed yet
		$recentRawHtml = RawHtml::constructByKey(array(
			'source_id' => $source->getSourceId(),
			'raw_html_hash' => $this->hash,
			'is_deleted' => false
		));
		
		return is_null($recentRawHtml);
		
	}
	
	
	public function getNewDataObject()
	{
		return new RawHtml();
	}
	
	public function setRawObjectFields(&$rawDataObject, &$rawData, $source)
	{
	
		$rawDataObject->setRawHtmlData($rawData);
		$rawDataObject->setRawHtmlHash($this->hash);
		$rawDataObject->setSourceId($source->getSourceId());
		$rawDataObject->setDateCreated(date('Y-m-d H:i:s', CURRENT_TIMESTAMP));
	
		return $rawDataObject;
		
	}
	
	public function spider()
	{
		parent::spider(SourceGroup::LINKEDIN_SOURCE_GROUP_ID);
	}
	
}
