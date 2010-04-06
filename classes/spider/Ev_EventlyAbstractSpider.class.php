<?php
abstract class Ev_EventlyAbstractSpider
{
	public function preFilter($data)
	{
		return $data;
	}
	
	public function isValid($data)
	{
		return false;
	}
	
	public function isNew($data)
	{
		return true;
	}
	
	
	public function getNewDataObject()
	{
		return null;
	}
	
	public function setRawObjectFields(&$rawDataObject, &$rawData, $source)
	{
	}
	
	public function spider($sourceGroupId)
	{
	
		$spiderEvents = new SpiderEvent_Collection();

		$sources = Source_Collection::getSourcesBySourceGroupId($sourceGroupId);

		foreach ($sources as $source)
		{
			echo 'loading source: '. $source->getName() . " feed " . $source->getFeed() ."\n";
			
			
			$rawDataObject = $this->getNewDataObject();
			$rawData = file_get_contents($source->getFeed());
			$rawData = $this->preFilter($rawData);
			$spiderEvents->add(SpiderEvent::buildBySourceAndStatusId($source->getSourceId(), SpiderStatus::ATTEMPTED_CONNECTION_STATUS_ID));

			// if we can't find a lastBuildDate, there probably isn't a feed there
			if (!$this->isValid($rawData))
			{
				$spiderEvents->add(SpiderEvent::buildBySourceAndStatusId($source->getSourceId(), SpiderStatus::NO_FEED_FOUND_STATUS_ID));
			}
			else
			{
				// only save if this is a new build of the feed
				if (!$this->isNew($rawData, $source))
				{
					$spiderEvents->add(SpiderEvent::buildBySourceAndStatusId($source->getSourceId(), SpiderStatus::DISCARDED_RAW_RSS_STATUS_ID));
				}
				else
				{
					$rawDataObject = $this->setRawObjectFields($rawDataObject, $rawData, $source);
					if ($rawDataObject->save())
					{
						$spiderEvents->add(SpiderEvent::buildBySourceAndStatusId($source->getSourceId(), SpiderStatus::SAVED_NEW_RSS_STATUS_ID));
						foreach ($spiderEvents as $spiderEvent)
						{
							$spiderEvent->setRawId($rawDataObject);
						}
					}
				}
			}
		}
		$spiderEvents->save();
		
		
	}
	
}

