<?php

/**
* This is the starter class for Venue_Collection_Generated.
 *
 * @see Venue_Collection_Generated, CoughCollection
 **/
class Venue_Collection extends Venue_Collection_Generated {
	
	public function loadByRect($rect)
	{
		
		list($swLat, $swLon, $neLat, $neLon) = $rect;
		
		$db = Venue::getDb();
		
		$sql = "
			SELECT
				venue.*
			FROM
				venue_location INNER JOIN venue ON (venue.venue_id = venue_location.venue_id)
			WHERE
				venue_location.is_deleted = 0 
				AND venue.is_deleted = 0
				AND
				MBRContains(
					GeomFromText(
						'Polygon((" . (float) $swLat ." " . (float) $swLon .", " . (float) $neLat . " " . (float) $swLon . ", " . (float) $neLat . " " . (float) $neLon . ", " . (float) $swLat ." " . (float) $neLon .", " . (float) $swLat. " " . (float) $swLon. "))'),
				   		venue_location.location
					)
				
			";
			
		$this->loadBySql($sql);
	}
}

?>