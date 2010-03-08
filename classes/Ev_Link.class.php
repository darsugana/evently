<?php
class Ev_Link
{
	public static function getLinkPath($path)
	{
		$city = City::getInstance();
		$cityPath = '/' . urlencode($city->getShortName());
		
		return $cityPath . $path;
	}
}