<?php

/**
 * This is the base class for VenueLocation.
 * 
 * @see VenueLocation, CoughObject
 **/
abstract class VenueLocation_Generated extends AppCoughObject {
	
	protected static $db = null;
	protected static $dbName = 'evently';
	protected static $tableName = 'venue_location';
	protected static $pkFieldNames = array('venue_location_id');
	
	protected $fields = array(
		'venue_location_id' => null,
		'venue_id' => null,
		'latitude' => null,
		'longitude' => null,
		'location' => null,
		'date_created' => null,
		'date_modified' => null,
	);
	
	protected $fieldDefinitions = array(
		'venue_location_id' => array(
			'db_column_name' => 'venue_location_id',
			'is_null_allowed' => false,
			'default_value' => null
		),
		'venue_id' => array(
			'db_column_name' => 'venue_id',
			'is_null_allowed' => false,
			'default_value' => null
		),
		'latitude' => array(
			'db_column_name' => 'latitude',
			'is_null_allowed' => false,
			'default_value' => null
		),
		'longitude' => array(
			'db_column_name' => 'longitude',
			'is_null_allowed' => false,
			'default_value' => null
		),
		'location' => array(
			'db_column_name' => 'location',
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
		'Venue_Object' => array(
			'class_name' => 'Venue'
		),
	);
	
	// Static Definition Methods
	
	public static function getDb() {
		if (is_null(VenueLocation::$db)) {
			VenueLocation::$db = CoughDatabaseFactory::getDatabase(VenueLocation::$dbName);
		}
		return VenueLocation::$db;
	}
	
	public static function getDbName() {
		return CoughDatabaseFactory::getDatabaseName(VenueLocation::$dbName);
	}
	
	public static function getTableName() {
		return VenueLocation::$tableName;
	}
	
	public static function getPkFieldNames() {
		return VenueLocation::$pkFieldNames;
	}
	
	// Static Construction (factory) Methods
	
	/**
	 * Constructs a new VenueLocation object from
	 * a single id (for single key PKs) or a hash of [field_name] => [field_value].
	 * 
	 * The key is used to pull data from the database, and, if no data is found,
	 * null is returned. You can use this function with any unique keys or the
	 * primary key as long as a hash is used. If the primary key is a single
	 * field, you may pass its value in directly without using a hash.
	 * 
	 * @param mixed $idOrHash - id or hash of [field_name] => [field_value]
	 * @return mixed - VenueLocation or null if no record found.
	 **/
	public static function constructByKey($idOrHash, $forPhp5Strict = '') {
		return CoughObject::constructByKey($idOrHash, 'VenueLocation');
	}
	
	/**
	 * Constructs a new VenueLocation object from custom SQL.
	 * 
	 * @param string $sql
	 * @return mixed - VenueLocation or null if exactly one record could not be found.
	 **/
	public static function constructBySql($sql, $forPhp5Strict = '') {
		return CoughObject::constructBySql($sql, 'VenueLocation');
	}
	
	/**
	 * Constructs a new VenueLocation object after
	 * checking the fields array to make sure the appropriate subclass is
	 * used.
	 * 
	 * No queries are run against the database.
	 * 
	 * @param array $hash - hash of [field_name] => [field_value] pairs
	 * @return VenueLocation
	 **/
	public static function constructByFields($hash) {
		return new VenueLocation($hash);
	}
	
	public static function getLoadSql() {
		$tableName = VenueLocation::getTableName();
		return '
			SELECT
				`' . $tableName . '`.*
			FROM
				`' . VenueLocation::getDbName() . '`.`' . $tableName . '`
		';
	}
	
	// Generated attribute accessors (getters and setters)
	
	public function getVenueLocationId() {
		return $this->getField('venue_location_id');
	}
	
	public function setVenueLocationId($value) {
		$this->setField('venue_location_id', $value);
	}
	
	public function getVenueId() {
		return $this->getField('venue_id');
	}
	
	public function setVenueId($value) {
		$this->setField('venue_id', $value);
	}
	
	public function getLatitude() {
		return $this->getField('latitude');
	}
	
	public function setLatitude($value) {
		$this->setField('latitude', $value);
	}
	
	public function getLongitude() {
		return $this->getField('longitude');
	}
	
	public function setLongitude($value) {
		$this->setField('longitude', $value);
	}
	
	public function getLocation() {
		return $this->getField('location');
	}
	
	public function setLocation($value) {
		$this->setField('location', $value);
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