<?php
class Ev_Link
{
	public static function getLinkPath($path)
	{
		$city = City::getInstance();
		$cityPath = '/' . urlencode($city->getShortName());
		if (strpos($url, $cityPath) === 0)
		{
			return $url;
		}
		
		return $cityPath . $path;
		
	}
}