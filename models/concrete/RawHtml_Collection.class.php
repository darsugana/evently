<?php

/**
* This is the starter class for RawHtml_Collection_Generated.
 *
 * @see RawHtml_Collection_Generated, CoughCollection
 **/
class RawHtml_Collection extends RawHtml_Collection_Generated {

	public static function getUnimportedHtmlBySourceId($sourceId, $limit = 5)
	{
		$db = RawRss::getDb();
		$sql = '
			SELECT
				*
			FROM
				raw_html
			WHERE
				is_deleted = 0
				AND source_id = ' . $db->quote($sourceId) . '
				AND is_imported = 0
			LIMIT
				' . (int)($limit) . '
		
		';
		
		$rawHtmls = new RawHtml_Collection();
		$rawHtmls->loadBySql($sql);
		
		return $rawHtmls;
		
	}

}

?>