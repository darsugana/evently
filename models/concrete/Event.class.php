<?php

/**
 * This is the starter class for Event_Generated.
 *
 * @see Event_Generated, CoughObject
 **/
class Event extends Event_Generated implements CoughObjectStaticInterface {
	private $weight;
	
	public function setWeight($weight)
	{
		$this->weight = $weight;
	}
	
	public function getWeight()
	{
		return $this->weight;
	}
	
	public static function constructByGuid($guid)
	{
		$db = self::getDb();
		$sql = '
			SELECT
				*
			FROM
				event
			WHERE
				guid = ' . $db->quote($guid) . ' 
				AND is_deleted = 0
			LIMIT 1
		';
		return self::constructBySql($sql);
		
	}
}

?>