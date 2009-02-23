<?php
/**
* This is the starter class for Event_Collection_Generated.
 *
 * @see Event_Collection_Generated, CoughCollection
 **/
class Event_Collection extends Event_Collection_Generated
{
	public function loadBySearchString($searchString)
	{
		$search = new Ev_Search('events_all');
		$result = $search->search($searchString);
		if (is_array($result['matches']))
		{
			$eventIds = array_keys($result['matches']);
			$db = Event::getDb();
			$sql = Event::getLoadSql();
			$sql .= '
				WHERE
					`event`.`event_id` IN (' . implode(', ', $eventIds)  . ')
					AND `event`.`date` >= ' . $db->quote(date('Y-m-d', time())) . '
					AND `event`.`is_deleted` = 0
				ORDER BY
					`event`.`date`
			';
			$this->loadBySql($sql);
		}
	}
}

