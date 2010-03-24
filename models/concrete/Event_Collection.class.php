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
		$search->setFieldWeights(
			array(
					'name' => 10,
					'description' => 20,
					'venue_name' => 5,
					'city_id' => 0,
					'vote_total' => 0,
				)
			);
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
					AND `event`.`vote_total` >= -50
				ORDER BY
					`event`.`date` ASC, `event`.`vote_total` DESC
			';
			$this->loadBySql($sql);
			foreach ($this as $event)
			{
				if (isset($result['matches'][$event->getEventId()]))
				{
					$event->setWeight($result['matches'][$event->getEventId()]['weight']);
				}
			}
		}
	}
	
	public function loadByArray($ids, $shouldShowPastEvents = false)
	{
		$city = City::getInstance();
		$eventIds = array();
		foreach($ids as $id)
		{
			$eventIds[] = (int) $id;
		}
		if (count($eventIds))
		{
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
					AND `event`.`vote_total` >= -50
					AND `event`.`city_id` = ' . $city->getCityId() . '
				ORDER BY
					`event`.`date` ASC, `event`.`vote_total` DESC
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
