<?php

/**
* This is the starter class for Event_Collection_Generated.
 *
 * @see Event_Collection_Generated, CoughCollection
 **/
class Event_Collection extends Event_Collection_Generated {
	
	public function loadBySearchString($searchString)
	{
		$sql = Event::getLoadSql();
		$sql .= '
			WHERE
				event.is_deleted = 0
			ORDER BY
				date DESC
			LIMIT 500
		';
		$this->loadBySql($sql);
	}
}

?>
