<?php

/**
 * This is the starter class for Venue_Generated.
 *
 * @see Venue_Generated, CoughObject
 **/
class Venue extends Venue_Generated implements CoughObjectStaticInterface {
	
	public static function constructByGuid($guid)
	{
		$db = self::getDb();
		$sql = '
			SELECT
				*
			FROM
				venue
			WHERE
				guid = ' . $db->quote($guid) . ' 
				AND is_deleted = 0
		';
		return self::constructBySql($sql);
		
	}
	
}

?>