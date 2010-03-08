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
	
	private static $instance = null;
	
	public static function constructByShortName($shortName)
	{
		return self::constructByKey(array('short_name'=> $shortName, 'is_deleted' => 0));
	}
	
	public static function loadDefaultInstance()
	{
		// try to match a city to the user's ip
		$geoip = @geoip_record_by_name($_SERVER['REMOTE_ADDR']);
		
		if (isset($geoip['city']) && !empty($geoip['city']))
		{
			switch ($geoip['city'])
			{
				case 'Austin':
					self::setInstance(self::constructByKey(self::AUSTIN));
					break;
				case 'New York':
					self::setInstance(self::constructByKey(self::NEW_YORK));
					break;
				case 'San Francisco':
					self::setInstance(self::constructByKey(self::SAN_FRANCISCO));
					break;
				default:
					self::setInstance(self::constructByKey(self::AUSTIN));
					break;
			}
		}
		else
		{
			self::setInstance(self::constructByKey(self::AUSTIN));
		}
	}
	
	public static function setInstance($city)
	{
		
		self::$instance = $city;
	}
	
	public static function getInstance()
	{
		if (is_null(self::$instance))
		{
			self::loadDefaultInstance();
		}

		return self::$instance;
		
	}
	
	
}

?>