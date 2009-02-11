<?php

/**
* This is the starter class for Event_Collection_Generated.
 *
 * @see Event_Collection_Generated, CoughCollection
 **/
class Event_Collection extends Event_Collection_Generated {
	
	public function loadBySearchString($searchString)
	{
		$this->load();
		$this->sortByMethod('getDate', SORT_DESC);
	}
}

?>