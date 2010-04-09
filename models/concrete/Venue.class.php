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
	
	public static function constructByName($name)
	{
		$db = self::getDb();
		$sql = '
			SELECT
				*
			FROM
				venue
			WHERE
				name = ' . $db->quote($name) . ' 
				AND is_deleted = 0
		';
		return self::constructBySql($sql);
		
	}
	
	
	// Does this work? I don't know.
	public static function constructByAddress($street1, $street2, $city, $state, $zip)
	{
		$db = self::getDb();
		$sql = new As_SelectQuery();
		$sql->setSelect('*');
		$sql->setFrom('venue');
		$sql->setWhere('is_deleted =  0');
		$sql->addWhere('street1 = ' . $db->quote($street1));
		if ($street2 != '')
		{
			$sql->addWhere('street2 = ' . $db->quote($street2));
		}
		if ($city != '')
		{
			$sql->addWhere('city= ' . $db->quote($city));
		}
		if ($state != '')
		{
			$sql->addWhere('state = ' . $db->quote($state));
		}
		if ($zip != '')
		{
			$sql->addWhere('zip_code = ' . $db->quote($zip));
		}
		
		$sql->setLimit(1);
		$sql->setOrderBy('venue_id DESC');
		
		return self::constructBySql($sql);
		
	}
	
}

?>