<?php

/**
 * This is the base class for Tag2venue.
 * 
 * @see Tag2venue, CoughObject
 **/
abstract class Tag2venue_Generated extends AppCoughObject {
	
	protected static $db = null;
	protected static $dbName = 'evently';
	protected static $tableName = 'tag2venue';
	protected static $pkFieldNames = array('tag_venue_id');
	
	protected $fields = array(
		'tag_venue_id' => null,
		'tag_id' => null,
		'venue_id' => null,
		'date_created' => null,
		'date_modified' => null,
		'is_deleted' => 0,
	);
	
	protected $fieldDefinitions = array(
		'tag_venue_id' => array(
			'db_column_name' => 'tag_venue_id',
			'is_null_allowed' => false,
			'default_value' => null
		),
		'tag_id' => array(
			'db_column_name' => 'tag_id',
			'is_null_allowed' => false,
			'default_value' => null
		),
		'venue_id' => array(
			'db_column_name' => 'venue_id',
			'is_null_allowed' => false,
			'default_value' => null
		),
		'date_created' => array(
			'db_column_name' => 'date_created',
			'is_null_allowed' => false,
			'default_value' => null
		),
		'date_modified' => array(
			'db_column_name' => 'date_modified',
			'is_null_allowed' => true,
			'default_value' => null
		),
		'is_deleted' => array(
			'db_column_name' => 'is_deleted',
			'is_null_allowed' => false,
			'default_value' => 0
		),
	);
	
	protected $objectDefinitions = array(
		'Tag_Object' => array(
			'class_name' => 'Tag'
		),
		'Venue_Object' => array(
			'class_name' => 'Venue'
		),
	);
	
	// Static Definition Methods
	
	public static function getDb() {
		if (is_null(Tag2venue::$db)) {
			Tag2venue::$db = CoughDatabaseFactory::getDatabase(Tag2venue::$dbName);
		}
		return Tag2venue::$db;
	}
	
	public static function getDbName() {
		return CoughDatabaseFactory::getDatabaseName(Tag2venue::$dbName);
	}
	
	public static function getTableName() {
		return Tag2venue::$tableName;
	}
	
	public static function getPkFieldNames() {
		return Tag2venue::$pkFieldNames;
	}
	
	// Static Construction (factory) Methods
	
	/**
	 * Constructs a new Tag2venue object from
	 * a single id (for single key PKs) or a hash of [field_name] => [field_value].
	 * 
	 * The key is used to pull data from the database, and, if no data is found,
	 * null is returned. You can use this function with any unique keys or the
	 * primary key as long as a hash is used. If the primary key is a single
	 * field, you may pass its value in directly without using a hash.
	 * 
	 * @param mixed $idOrHash - id or hash of [field_name] => [field_value]
	 * @return mixed - Tag2venue or null if no record found.
	 **/
	public static function constructByKey($idOrHash, $forPhp5Strict = '') {
		return CoughObject::constructByKey($idOrHash, 'Tag2venue');
	}
	
	/**
	 * Constructs a new Tag2venue object from custom SQL.
	 * 
	 * @param string $sql
	 * @return mixed - Tag2venue or null if exactly one record could not be found.
	 **/
	public static function constructBySql($sql, $forPhp5Strict = '') {
		return CoughObject::constructBySql($sql, 'Tag2venue');
	}
	
	/**
	 * Constructs a new Tag2venue object after
	 * checking the fields array to make sure the appropriate subclass is
	 * used.
	 * 
	 * No queries are run against the database.
	 * 
	 * @param array $hash - hash of [field_name] => [field_value] pairs
	 * @return Tag2venue
	 **/
	public static function constructByFields($hash) {
		return new Tag2venue($hash);
	}
	
	public static function getLoadSql() {
		$tableName = Tag2venue::getTableName();
		return '
			SELECT
				`' . $tableName . '`.*
			FROM
				`' . Tag2venue::getDbName() . '`.`' . $tableName . '`
		';
	}
	
	// Generated attribute accessors (getters and setters)
	
	public function getTagVenueId() {
		return $this->getField('tag_venue_id');
	}
	
	public function setTagVenueId($value) {
		$this->setField('tag_venue_id', $value);
	}
	
	public function getTagId() {
		return $this->getField('tag_id');
	}
	
	public function setTagId($value) {
		$this->setField('tag_id', $value);
	}
	
	public function getVenueId() {
		return $this->getField('venue_id');
	}
	
	public function setVenueId($value) {
		$this->setField('venue_id', $value);
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
	
	public function getIsDeleted() {
		return $this->getField('is_deleted');
	}
	
	public function setIsDeleted($value) {
		$this->setField('is_deleted', $value);
	}
	
	// Generated one-to-one accessors (loaders, getters, and setters)
	
	public function loadTag_Object() {
		$this->setTag_Object(Tag::constructByKey($this->getTagId()));
	}
	
	public function getTag_Object() {
		if (!isset($this->objects['Tag_Object'])) {
			$this->loadTag_Object();
		}
		return $this->objects['Tag_Object'];
	}
	
	public function setTag_Object($tag) {
		$this->objects['Tag_Object'] = $tag;
	}
	
	public function loadVenue_Object() {
		$this->setVenue_Object(Venue::constructByKey($this->getVenueId()));
	}
	
	public function getVenue_Object() {
		if (!isset($this->objects['Venue_Object'])) {
			$this->loadVenue_Object();
		}
		return $this->objects['Venue_Object'];
	}
	
	public function setVenue_Object($venue) {
		$this->objects['Venue_Object'] = $venue;
	}
	
	// Generated one-to-many collection loaders, getters, setters, adders, and removers
	
}

?>