<?php

/**
 * This is the starter class for City_Generated.
 *
 * @see City_Generated, CoughObject
 **/
class City extends City_Generated implements CoughObjectStaticInterface {
	
	const AUSTIN = 1;
	const NEW_YORK = 2;
	const SAN_FRANCISCO = 3;
	
	static $instance = null;
	
	public static function constructByShortName($shortName)
	{
		return self::constructByKey(array('short_name'=> $shortName, 'is_deleted' => 0));
	}
	
	public static function loadDefaultInstance()
	{
		self::setInstance(self::constructByKey(self::AUSTIN));
	}
	
	public static function setInstance($city)
	{
		self::$instance = $city;
	}
	
	public static function getInstance()
	{
		if (is_null(self::$instance))
		{
			self::$instance = self::loadDefaultInstance();
		}
		
		return self::$instance;
		
	}
	
	
}

?>