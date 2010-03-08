<?php
/**
* This is the starter class for Event_Collection_Generated.
 *
 * @see Event_Collection_Generated, CoughCollection
 **/
class Event_Collection extends Event_Collection_Generated
{
	public function loadBySearchString($searchString, $shouldShowPastEvents = false)
	{
		$search = new Ev_Search();
		$city = City::getInstance();
		if (is_object($city))
		{
			$search->setFilter('city_id', array($city->getKeyId()));
		}
		$result = $search->search($searchString);
		if (isset($result['matches']) && is_array($result['matches']))
		{
			$eventIds = array_keys($result['matches']);
			$db = Event::getDb();
			$sql = Event::getLoadSql();
			$sql .= '
				WHERE
					`event`.`event_id` IN (' . implode(', ', $eventIds)  . ')
			';
			if (!$shouldShowPastEvents) {
				$sql .= '
					AND `event`.`date` >= ' . $db->quote(date('Y-m-d', time())) . '
				';
			}
			$sql .= '
					AND `event`.`is_deleted` = 0
				ORDER BY
					`event`.`date`
			';
			$this->loadBySql($sql);
		}
	}
	
	public function getEventsChunkedByDate()
	{
		$events = array();
		foreach ($this as $event) {
			$events[date('Y-m-d', strtotime($event->getDate()))][$event->getEventId()] = $event;
		}
		return $events;
	}
}
