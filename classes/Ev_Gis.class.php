<?php
class Ev_Gis
{

	// from http://www.zipcodeworld.com/samples/distance.php.html
	public static function distance($lat1, $lon1, $lat2, $lon2, $unit) { 

	  $theta = $lon1 - $lon2; 
	  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)); 
	  $dist = acos($dist); 
	  $dist = rad2deg($dist); 
	  $miles = $dist * 60 * 1.1515;
	  $unit = strtoupper($unit);

	  if ($unit == "K") {
	    return ($miles * 1.609344); 
	  } else if ($unit == "N") {
	      return ($miles * 0.8684);
	  } else {
	     return $miles;
      }

	}

	public static function rectCenteredOn($lat, $lon, $distance)
	{
		$oneMileInDegrees = 1/69;
		
		$swLat = $lat - $oneMileInDegrees * $distance;
		$swLon = $lon - $oneMileInDegrees * $distance;
		
		$neLat = $lat + $oneMileInDegrees * $distance;
		$neLon = $lat + $oneMileInDegrees * $distance;
		
		return array($swLat, $swLon, $neLat, $neLon);		
	}

}