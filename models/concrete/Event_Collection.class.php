<?php

/**
* This is the starter class for Event_Collection_Generated.
 *
 * @see Event_Collection_Generated, CoughCollection
 **/
class Event_Collection extends Event_Collection_Generated {
	
	public function loadBySearchString($searchString)
	{
		$search = new Ev_Search('events_all');
		$result = $search->search($searchString);
		$eventIds = array_keys($result['matches']);
		$sql = Event::getLoadSql();
		$sql .= '
			WHERE
				event.event_id IN (' . implode(', ', $eventIds)  . ')
		';
		$this->loadBySql($sql);
	}
}

?>
