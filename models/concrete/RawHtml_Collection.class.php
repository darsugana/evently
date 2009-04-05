<?php

/**
* This is the starter class for RawHtml_Collection_Generated.
 *
 * @see RawHtml_Collection_Generated, CoughCollection
 **/
class RawHtml_Collection extends RawHtml_Collection_Generated {


	public static function getUnimportedHtmlBySourceGroupId($sourceGroupId, $limit = 5)
	{
		$db = RawHtml::getDb();
		$sql = '
			SELECT
				raw_html.*,
				' . implode(',', CoughObject::getFieldAliases('Source', 'Source_Object')) . '
			FROM
				raw_html
				INNER JOIN source ON (raw_html.source_id = source.source_id)
			WHERE
				raw_html.is_deleted = 0
				AND source.source_group_id = ' . $db->quote($sourceGroupId) . '
				AND raw_html.is_imported = 0
			LIMIT
				' . (int)($limit) . '
		
		';
		
		$rawHtmls = new RawHtml_Collection();
		$rawHtmls->loadBySql($sql);
		
		return $rawHtmls;
		
	}

}

?>