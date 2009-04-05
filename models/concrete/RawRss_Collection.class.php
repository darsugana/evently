<?php

/**
* This is the starter class for RawRss_Collection_Generated.
 *
 * @see RawRss_Collection_Generated, CoughCollection
 **/
class RawRss_Collection extends RawRss_Collection_Generated {
	public static function getUnimportedRssBySourceGroupId($sourceGroupId, $limit = 5)
	{
		$db = RawRss::getDb();
		$sql = '
			SELECT
				raw_rss.*,
				' . implode(',', CoughObject::getFieldAliases('Source', 'Source_Object')) . '
			FROM
				raw_rss
				INNER JOIN source ON (raw_rss.source_id = source.source_id)
			WHERE
				raw_rss.is_deleted = 0
				AND source.source_group_id = ' . $db->quote($sourceGroupId) . '
				AND raw_rss.is_imported = 0
			LIMIT
				' . (int)($limit) . '
		
		';
		
		$rawRsses = new RawRss_Collection();
		$rawRsses->loadBySql($sql);
		
		return $rawRsses;
		
	}
	
}

?>