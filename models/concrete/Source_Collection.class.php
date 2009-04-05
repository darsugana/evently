<?php

/**
* This is the starter class for Source_Collection_Generated.
 *
 * @see Source_Collection_Generated, CoughCollection
 **/
class Source_Collection extends Source_Collection_Generated {
	
	public static function getSourcesBySourceGroupId($sourceGroupId)
	{
		$db = Source::getDb();
		$sql = '
			SELECT
				source.*
			FROM
				source
			WHERE
				source.is_deleted = 0
				AND source.source_group_id = ' . $db->quote($sourceGroupId) . '
		';

		$sources = new Source_Collection();
		$sources->loadBySql($sql);
		
		return $sources;
		
	}
	
}

?>