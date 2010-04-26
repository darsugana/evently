<?php
/**
* This is the starter class for Event_Collection_Generated.
 *
 * @see Event_Collection_Generated, CoughCollection
 **/
class Event_Collection extends Event_Collection_Generated
{
	public function loadByCriteria($criteria)
	{
		$criteria = $criteria + array(
			'q' => null,
			'latitude' => null,
			'longitude' => null,
			'within' => 2,
			'city_id' => City::AUSTIN,
			'show_past_events' => false,
			'tag' => null,
		);
		
		$db = Event::getDb();
		$sql = new As_SelectQuery();
		$sql->addSelect('`' . Event::getTableName() . '`.*');
		$sql->addFrom('`' . Event::getDbName() . '`.`' . Event::getTableName() . '`');
		
		$city = City::constructByKey($criteria['city_id']);
		
		if (!is_null($criteria['q']) && trim($criteria['q']) != '')
		{
			$search = new Ev_Search();
			$search->setFieldWeights(array(
				'name' => 10,
				'description' => 20,
				'venue_name' => 5,
				'city_id' => 0,
				'vote_total' => 0,
			));
			
			$result = $search->search($criteria['q']);
			if (isset($result['matches']) && is_array($result['matches']))
			{
				$eventIds = array_keys($result['matches']);
				$sql->addWhere('`' . Event::getTableName() . '`.`event_id` IN (' . implode(', ', $eventIds)  . ')');
			}
			else
			{
				// No results
				return;
			}
		}
		
		$sql->addWhere('`' . Event::getTableName() . '`.`is_deleted` = 0');
		$sql->addWhere('`' . Event::getTableName() . '`.`vote_total` >= -50');
		$sql->addWhere('`' . Event::getTableName() . '`.`city_id` = ' . $db->quote($city->getCityId()));
		
		if (!$criteria['show_past_events'])
		{
			$sql->addWhere('`' . Event::getTableName() . '`.`date` >= ' . $db->quote(date('Y-m-d', time())));
		}
		
		if (!is_null($criteria['latitude']) && !is_null($criteria['longitude']))
		{
			$sql->addFrom('
				INNER JOIN `' . Venue::getDbName() . '`.`' . Venue::getTableName() . '` USING (`venue_id`)
				INNER JOIN `' . VenueLocation::getDbName() . '`.`' . VenueLocation::getTableName() . '` USING (`venue_id`)
			');
			
			$rect = Ev_Gis::rectCenteredOn($criteria['latitude'], $criteria['longitude'], $criteria['within']);
			list($swLat, $swLon, $neLat, $neLon) = $rect;
			$sql->addWhere("
				MBRContains(
					GeomFromText(
						'Polygon((" . (float) $swLat ." " . (float) $swLon .", " . (float) $neLat . " " . (float) $swLon . ", " . (float) $neLat . " " . (float) $neLon . ", " . (float) $swLat ." " . (float) $neLon .", " . (float) $swLat. " " . (float) $swLon. "))'
					),
					`" . VenueLocation::getTableName() . "`.`location`
				)
			");
		}
		
		if (isset($criteria['tag']) && trim($criteria['tag']) != '')
		{
			$sql->addFrom('
				INNER JOIN `' . Tag2event::getDbName() . '`.`' . Tag2event::getTableName() . '` ON
					`' . Tag2event::getTableName() . '`.`event_id` = event.event_id
					AND `' . Tag2event::getTableName() . '`.`is_deleted` = 0
				INNER JOIN `' . Tag::getDbName() . '`.`' . Tag::getTableName() . '` ON
					`' . Tag::getTableName() . '`.`tag_id` = `' . Tag2event::getTableName() . '`.`tag_id`
					AND `' . Tag::getTableName() . '`.`is_deleted` = 0
			');
			$sql->addWhere('`' . Tag::getTableName() . '`.`name` = ' . $db->quote(trim($criteria['tag'])));
		}
		
		$sql->addOrderBy('
			`' . Event::getTableName() . '`.`date` ASC,
			`' . Event::getTableName() . '`.`vote_total` DESC
		');
		
		$this->loadBySql($sql);
		
		if (!is_null($criteria['q']) && (trim($criteria['q']) != '') && isset($result['matches']) && is_array($result['matches']))
		{
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
