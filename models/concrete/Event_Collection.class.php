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
		if (!is_array($ids))
		{
			return;
		}
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
	
	public function loadByTag($tagName, $shouldShowPastEvents = false)
	{
		$db = Event::getDb();
		$sql = '
			SELECT
				event.*
			FROM
				event
				INNER JOIN tag2event
					ON tag2event.event_id = event.event_id
					AND tag2event.is_deleted = 0
				INNER JOIN tag
					ON tag.tag_id = tag2event.tag_id
					AND tag.is_deleted = 0
			WHERE
				event.is_deleted = 0
				AND tag.name = ' . $db->quote($tagName) .'
				';
		if (!$shouldShowPastEvents) {
			$sql .= '
				AND `event`.`date` >= ' . $db->quote(date('Y-m-d', time())) . '
			';
		}
		$sql .= '
			ORDER BY 
				event.date ASC, event.vote_total DESC
		';
		
		
		$this->loadBySql($sql);
	}
	
	
	public function getEventsChunkedByDate()
	{
		$events = array();
		foreach ($this as $event) {
			$events[date('Y-m-d', strtotime($event->getDate()))][$event->getEventId()] = $event;
		}
		return $events;
	}
	
	public function loadRsvps($userId)
	{
		$db = Event::getDb();
		
		$eventIds = array();
		foreach ($this as $event)
		{
			$eventIds[] = $db->quote($event->getEventId());
		}
		if (count($eventIds) == 0)
		{
			return;
		}
		$sql = '
			SELECT
				event_id,
				1 as is_attending
			FROM
				rsvp
			WHERE
				is_deleted = 0
				AND event_id IN ('. implode(',', $eventIds) . ')
				AND user_id = ' . $db->quote($userId) . '
		';
		

		$result = $db->query($sql);
		while ($row = $result->getRow())
		{
			$event = $this->get($row['event_id']);
			if (is_object($event))
			{
				$event->setFields($row);
			}
		}	
		
	}
	
	
	public function loadVotes($userId)
	{
		$db = Event::getDb();
		
		$eventIds = array();
		foreach ($this as $event)
		{
			$eventIds[] = $db->quote($event->getEventId());
		}
		if (count($eventIds) == 0)
		{
			return;
		}
		$sql = '
			SELECT
				event_id,
				value AS user_vote
			FROM
				event_vote
			WHERE
				is_deleted = 0
				AND event_id IN ('. implode(',', $eventIds) . ')
				AND user_id = ' . $db->quote($userId) . '
		';
		

		$result = $db->query($sql);
		while ($row = $result->getRow())
		{
			$event = $this->get($row['event_id']);
			if (is_object($event))
			{
				$event->setFields($row);
			}
		}	
		
	}
	
}
