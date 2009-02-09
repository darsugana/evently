<?php

/**
* This is the starter class for RawRss_Collection_Generated.
 *
 * @see RawRss_Collection_Generated, CoughCollection
 **/
class RawRss_Collection extends RawRss_Collection_Generated {
	public static function getUnimportedRssBySourceId($sourceId, $limit = 5)
	{
		$db = RawRss::getDb();
		$sql = '
			SELECT
				*
			FROM
				raw_rss
			WHERE
				is_deleted = 0
				AND source_id = ' . $db->quote($sourceId) . '
				AND is_imported = 0
			LIMIT
				' . (int)($limit) . '
		
		';
		
		$rawRsses = new RawRss_Collection();
		$rawRsses->loadBySql($sql);
		
		return $rawRsses;
		
	}
	
}

?>