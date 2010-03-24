<?php

/**
 * This is the base class for EventVote.
 * 
 * @see EventVote, CoughObject
 **/
abstract class EventVote_Generated extends AppCoughObject {
	
	protected static $db = null;
	protected static $dbName = 'evently';
	protected static $tableName = 'event_vote';
	protected static $pkFieldNames = array('event_vote_id');
	
	protected $fields = array(
		'event_vote_id' => null,
		'event_id' => null,
		'user_id' => null,
		'value' => null,
		'is_deleted' => null,
		'date_created' => null,
		'date_modified' => null,
	);
	
	protected $fieldDefinitions = array(
		'event_vote_id' => array(
			'db_column_name' => 'event_vote_id',
			'is_null_allowed' => false,
			'default_value' => null
		),
		'event_id' => array(
			'db_column_name' => 'event_id',
			'is_null_allowed' => false,
			'default_value' => null
		),
		'user_id' => array(
			'db_column_name' => 'user_id',
			'is_null_allowed' => true,
			'default_value' => null
		),
		'value' => array(
			'db_column_name' => 'value',
			'is_null_allowed' => false,
			'default_value' => null
		),
		'is_deleted' => array(
			'db_column_name' => 'is_deleted',
			'is_null_allowed' => false,
			'default_value' => null
		),
		'date_created' => array(
			'db_column_name' => 'date_created',
			'is_null_allowed' => true,
			'default_value' => null
		),
		'date_modified' => array(
			'db_column_name' => 'date_modified',
			'is_null_allowed' => true,
			'default_value' => null
		),
	);
	
	protected $objectDefinitions = array(
		'Event_Object' => array(
			'class_name' => 'Event'
		),
		'User_Object' => array(
			'class_name' => 'User'
		),
	);
	
	// Static Definition Methods
	
	public static function getDb() {
		if (is_null(EventVote::$db)) {
			EventVote::$db = CoughDatabaseFactory::getDatabase(EventVote::$dbName);
		}
		return EventVote::$db;
	}
	
	public static function getDbName() {
		return CoughDatabaseFactory::getDatabaseName(EventVote::$dbName);
	}
	
	public static function getTableName() {
		return EventVote::$tableName;
	}
	
	public static function getPkFieldNames() {
		return EventVote::$pkFieldNames;
	}
	
	// Static Construction (factory) Methods
	
	/**
	 * Constructs a new EventVote object from
	 * a single id (for single key PKs) or a hash of [field_name] => [field_value].
	 * 
	 * The key is used to pull data from the database, and, if no data is found,
	 * null is returned. You can use this function with any unique keys or the
	 * primary key as long as a hash is used. If the primary key is a single
	 * field, you may pass its value in directly without using a hash.
	 * 
	 * @param mixed $idOrHash - id or hash of [field_name] => [field_value]
	 * @return mixed - EventVote or null if no record found.
	 **/
	public static function constructByKey($idOrHash, $forPhp5Strict = '') {
		return CoughObject::constructByKey($idOrHash, 'EventVote');
	}
	
	/**
	 * Constructs a new EventVote object from custom SQL.
	 * 
	 * @param string $sql
	 * @return mixed - EventVote or null if exactly one record could not be found.
	 **/
	public static function constructBySql($sql, $forPhp5Strict = '') {
		return CoughObject::constructBySql($sql, 'EventVote');
	}
	
	/**
	 * Constructs a new EventVote object after
	 * checking the fields array to make sure the appropriate subclass is
	 * used.
	 * 
	 * No queries are run against the database.
	 * 
	 * @param array $hash - hash of [field_name] => [field_value] pairs
	 * @return EventVote
	 **/
	public static function constructByFields($hash) {
		return new EventVote($hash);
	}
	
	public static function getLoadSql() {
		$tableName = EventVote::getTableName();
		return '
			SELECT
				`' . $tableName . '`.*
			FROM
				`' . EventVote::getDbName() . '`.`' . $tableName . '`
		';
	}
	
	// Generated attribute accessors (getters and setters)
	
	public function getEventVoteId() {
		return $this->getField('event_vote_id');
	}
	
	public function setEventVoteId($value) {
		$this->setField('event_vote_id', $value);
	}
	
	public function getEventId() {
		return $this->getField('event_id');
	}
	
	public function setEventId($value) {
		$this->setField('event_id', $value);
	}
	
	public function getUserId() {
		return $this->getField('user_id');
	}
	
	public function setUserId($value) {
		$this->setField('user_id', $value);
	}
	
	public function getValue() {
		return $this->getField('value');
	}
	
	public function setValue($value) {
		$this->setField('value', $value);
	}
	
	public function getIsDeleted() {
		return $this->getField('is_deleted');
	}
	
	public function setIsDeleted($value) {
		$this->setField('is_deleted', $value);
	}
	
	public function getDateCreated() {
		return $this->getField('date_created');
	}
	
	public function setDateCreated($value) {
		$this->setField('date_created', $value);
	}
	
	public function getDateModified() {
		return $this->getField('date_modified');
	}
	
	public function setDateModified($value) {
		$this->setField('date_modified', $value);
	}
	
	// Generated one-to-one accessors (loaders, getters, and setters)
	
	public function loadEvent_Object() {
		$this->setEvent_Object(Event::constructByKey($this->getEventId()));
	}
	
	public function getEvent_Object() {
		if (!isset($this->objects['Event_Object'])) {
			$this->loadEvent_Object();
		}
		return $this->objects['Event_Object'];
	}
	
	public function setEvent_Object($event) {
		$this->objects['Event_Object'] = $event;
	}
	
	public function loadUser_Object() {
		$this->setUser_Object(User::constructByKey($this->getUserId()));
	}
	
	public function getUser_Object() {
		if (!isset($this->objects['User_Object'])) {
			$this->loadUser_Object();
		}
		return $this->objects['User_Object'];
	}
	
	public function setUser_Object($user) {
		$this->objects['User_Object'] = $user;
	}
	
	// Generated one-to-many collection loaders, getters, setters, adders, and removers
	
}

?>