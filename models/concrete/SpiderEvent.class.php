<?php

/**
 * This is the starter class for SpiderEvent_Generated.
 *
 * @see SpiderEvent_Generated, CoughObject
 **/
class SpiderEvent extends SpiderEvent_Generated implements CoughObjectStaticInterface
{
	public static function buildBySourceAndStatusId($sourceId, $statusId)
	{
		$spiderEvent = new SpiderEvent();
		$spiderEvent->setSourceId($sourceId);
		$spiderEvent->setSpiderStatusId($statusId);
		$spiderEvent->setDateCreated(date('Y-m-d H:i:s', CURRENT_TIMESTAMP));
		$spiderEvent->setIsDeleted(false);
		return $spiderEvent;
	}
}

?>