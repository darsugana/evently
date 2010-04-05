<?php

/**
 * This is the starter class for Event_Generated.
 *
 * @see Event_Generated, CoughObject
 **/
class Event extends Event_Generated implements CoughObjectStaticInterface {
	private $weight;
	
	protected $derivedFields = array(
		'is_attending' => false,
		'user_vote' => 0,
		);

	protected $derivedFieldDefinitions = array(
		'is_attending' => true,
		'user_vote' => true
		);

	
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
			SET
				vote_total = 0
			WHERE
				event.is_deleted = 0
				AND event.event_id = ' . $db->quote($this->getEventId()) . '			
		
		';

		$db->query($sql);

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
	
	public function updateRsvpTotal()
	{
		$db = self::getDb();
		$sql = '
			UPDATE
				event
				INNER JOIN (
						SELECT 
							event_id, 
							count(*) AS total
						FROM
							rsvp
						WHERE
							is_deleted = 0
						GROUP BY
							event_id
							) AS rsvp_sum ON event.event_id = rsvp_sum.event_id
			SET
				event.rsvp_total = rsvp_sum.total

			WHERE
				event.is_deleted = 0
				AND event.event_id = ' . $db->quote($this->getEventId()) . '
		';

		$db->query($sql);
		
	}
	
	public function getIsAttending()
	{
		return $this->getDerivedField('is_attending');
	}

	public function getUserVote()
	{
		return $this->getDerivedField('user_vote');
	}

	public function getLikes()
	{
		return ($this->getDerivedField('user_vote') > 0);
	}
	
	public function getDislikes()
	{
		return ($this->getDerivedField('user_vote') < 0);		
	}
}

?>