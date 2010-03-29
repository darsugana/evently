<?php

/**
 * This is the starter class for Event_Generated.
 *
 * @see Event_Generated, CoughObject
 **/
class Event extends Event_Generated implements CoughObjectStaticInterface {
	private $weight;
	
	public function setWeight($weight)
	{
		$this->weight = $weight;
	}
	
	public function getWeight()
	{
		return $this->weight;
	}
	
	public static function constructByGuid($guid)
	{
		$db = self::getDb();
		$sql = '
			SELECT
				*
			FROM
				event
			WHERE
				guid = ' . $db->quote($guid) . ' 
				AND is_deleted = 0
			LIMIT 1
		';
		return self::constructBySql($sql);
		
	}
	
	public function updateVoteTotal()
	{
		$db = self::getDb();

		$sql = '
			UPDATE
				event
				INNER JOIN (
						SELECT 
							event_id, 
							SUM(value) AS total
						FROM
							event_vote
						WHERE
							is_deleted = 0
						GROUP BY
							event_id
							) AS event_sum ON event.event_id = event_sum.event_id
			SET
				event.vote_total = event_sum.total

			WHERE
				event.is_deleted = 0
				AND event.event_id = ' . $db->quote($this->getEventId()) . '
		';

		$db->query($sql);	
		
	}
	
	public function getTags()
	{
		$tags = new Tag_Collection();
		$tags->loadByEventId($this->getEventId());
		
		return $tags;
	}
	
	public function getCategoryName()
	{
		if (is_null($this->getCategoryId()))
		{
			return '';
		}
		$categoriesById = Category_Collection::getCategoryArray();
		if (isset($categoriesById[$this->getCategoryId()]))
		{
			return $categoriesById[$this->getCategoryId()]->getName();
		}
		return '';
	}
	
}

?>