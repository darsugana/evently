<?php

/**
 * This is the base class for Venue.
 * 
 * @see Venue, CoughObject
 **/
abstract class Venue_Generated extends AppCoughObject {
	
	protected static $db = null;
	protected static $dbName = 'evently';
	protected static $tableName = 'venue';
	protected static $pkFieldNames = array('venue_id');
	
	protected $fields = array(
		'venue_id' => null,
		'name' => null,
		'description' => null,
		'guid' => null,
		'street1' => null,
		'street2' => null,
		'state' => null,
		'zip_code' => null,
		'country' => null,
		'city' => null,
		'phone' => null,
		'url' => null,
		'latitude' => null,
		'longitude' => null,
		'date_modified' => null,
		'date_created' => null,
		'is_deleted' => 0,
	);
	
	protected $fieldDefinitions = array(
		'venue_id' => array(
			'db_column_name' => 'venue_id',
			'is_null_allowed' => false,
			'default_value' => null
		),
		'name' => array(
			'db_column_name' => 'name',
			'is_null_allowed' => false,
			'default_value' => null
		),
		'description' => array(
			'db_column_name' => 'description',
			'is_null_allowed' => true,
			'default_value' => null
		),
		'guid' => array(
			'db_column_name' => 'guid',
			'is_null_allowed' => true,
			'default_value' => null
		),
		'street1' => array(
			'db_column_name' => 'street1',
			'is_null_allowed' => true,
			'default_value' => null
		),
		'street2' => array(
			'db_column_name' => 'street2',
			'is_null_allowed' => true,
			'default_value' => null
		),
		'state' => array(
			'db_column_name' => 'state',
			'is_null_allowed' => true,
			'default_value' => null
		),
		'zip_code' => array(
			'db_column_name' => 'zip_code',
			'is_null_allowed' => true,
			'default_value' => null
		),
		'country' => array(
			'db_column_name' => 'country',
			'is_null_allowed' => true,
			'default_value' => null
		),
		'city' => array(
			'db_column_name' => 'city',
			'is_null_allowed' => true,
			'default_value' => null
		),
		'phone' => array(
			'db_column_name' => 'phone',
			'is_null_allowed' => true,
			'default_value' => null
		),
		'url' => array(
			'db_column_name' => 'url',
			'is_null_allowed' => true,
			'default_value' => null
		),
		'latitude' => array(
			'db_column_name' => 'latitude',
			'is_null_allowed' => true,
			'default_value' => null
		),
		'longitude' => array(
			'db_column_name' => 'longitude',
			'is_null_allowed' => true,
			'default_value' => null
		),
		'date_modified' => array(
			'db_column_name' => 'date_modified',
			'is_null_allowed' => true,
			'default_value' => null
		),
		'date_created' => array(
			'db_column_name' => 'date_created',
			'is_null_allowed' => true,
			'default_value' => null
		),
		'is_deleted' => array(
			'db_column_name' => 'is_deleted',
			'is_null_allowed' => false,
			'default_value' => 0
		),
	);
	
	protected $objectDefinitions = array();
	
	// Static Definition Methods
	
	public static function getDb() {
		if (is_null(Venue::$db)) {
			Venue::$db = CoughDatabaseFactory::getDatabase(Venue::$dbName);
		}
		return Venue::$db;
	}
	
	public static function getDbName() {
		return CoughDatabaseFactory::getDatabaseName(Venue::$dbName);
	}
	
	public static function getTableName() {
		return Venue::$tableName;
	}
	
	public static function getPkFieldNames() {
		return Venue::$pkFieldNames;
	}
	
	// Static Construction (factory) Methods
	
	/**
	 * Constructs a new Venue object from
	 * a single id (for single key PKs) or a hash of [field_name] => [field_value].
	 * 
	 * The key is used to pull data from the database, and, if no data is found,
	 * null is returned. You can use this function with any unique keys or the
	 * primary key as long as a hash is used. If the primary key is a single
	 * field, you may pass its value in directly without using a hash.
	 * 
	 * @param mixed $idOrHash - id or hash of [field_name] => [field_value]
	 * @return mixed - Venue or null if no record found.
	 **/
	public static function constructByKey($idOrHash, $forPhp5Strict = '') {
		return CoughObject::constructByKey($idOrHash, 'Venue');
	}
	
	/**
	 * Constructs a new Venue object from custom SQL.
	 * 
	 * @param string $sql
	 * @return mixed - Venue or null if exactly one record could not be found.
	 **/
	public static function constructBySql($sql, $forPhp5Strict = '') {
		return CoughObject::constructBySql($sql, 'Venue');
	}
	
	/**
	 * Constructs a new Venue object after
	 * checking the fields array to make sure the appropriate subclass is
	 * used.
	 * 
	 * No queries are run against the database.
	 * 
	 * @param array $hash - hash of [field_name] => [field_value] pairs
	 * @return Venue
	 **/
	public static function constructByFields($hash) {
		return new Venue($hash);
	}
	
	public static function getLoadSql() {
		$tableName = Venue::getTableName();
		return '
			SELECT
				`' . $tableName . '`.*
			FROM
				`' . Venue::getDbName() . '`.`' . $tableName . '`
		';
	}
	
	// Generated attribute accessors (getters and setters)
	
	public function getVenueId() {
		return $this->getField('venue_id');
	}
	
	public function setVenueId($value) {
		$this->setField('venue_id', $value);
	}
	
	public function getName() {
		return $this->getField('name');
	}
	
	public function setName($value) {
		$this->setField('name', $value);
	}
	
	public function getDescription() {
		return $this->getField('description');
	}
	
	public function setDescription($value) {
		$this->setField('description', $value);
	}
	
	public function getGuid() {
		return $this->getField('guid');
	}
	
	public function setGuid($value) {
		$this->setField('guid', $value);
	}
	
	public function getStreet1() {
		return $this->getField('street1');
	}
	
	public function setStreet1($value) {
		$this->setField('street1', $value);
	}
	
	public function getStreet2() {
		return $this->getField('street2');
	}
	
	public function setStreet2($value) {
		$this->setField('street2', $value);
	}
	
	public function getState() {
		return $this->getField('state');
	}
	
	public function setState($value) {
		$this->setField('state', $value);
	}
	
	public function getZipCode() {
		return $this->getField('zip_code');
	}
	
	public function setZipCode($value) {
		$this->setField('zip_code', $value);
	}
	
	public function getCountry() {
		return $this->getField('country');
	}
	
	public function setCountry($value) {
		$this->setField('country', $value);
	}
	
	public function getCity() {
		return $this->getField('city');
	}
	
	public function setCity($value) {
		$this->setField('city', $value);
	}
	
	public function getPhone() {
		return $this->getField('phone');
	}
	
	public function setPhone($value) {
		$this->setField('phone', $value);
	}
	
	public function getUrl() {
		return $this->getField('url');
	}
	
	public function setUrl($value) {
		$this->setField('url', $value);
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
	
	public function getDateModified() {
		return $this->getField('date_modified');
	}
	
	public function setDateModified($value) {
		$this->setField('date_modified', $value);
	}
	
	public function getDateCreated() {
		return $this->getField('date_created');
	}
	
	public function setDateCreated($value) {
		$this->setField('date_created', $value);
	}
	
	public function getIsDeleted() {
		return $this->getField('is_deleted');
	}
	
	public function setIsDeleted($value) {
		$this->setField('is_deleted', $value);
	}
	
	// Generated one-to-one accessors (loaders, getters, and setters)
	
	// Generated one-to-many collection loaders, getters, setters, adders, and removers
	
}

?>