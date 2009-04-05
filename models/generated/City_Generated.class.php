<?php

/**
 * This is the base class for City.
 * 
 * @see City, CoughObject
 **/
abstract class City_Generated extends AppCoughObject {
	
	protected static $db = null;
	protected static $dbName = 'evently';
	protected static $tableName = 'city';
	protected static $pkFieldNames = array('city_id');
	
	protected $fields = array(
		'city_id' => null,
		'short_name' => null,
		'long_name' => null,
		'state' => null,
		'date_created' => null,
		'date_modified' => null,
		'is_deleted' => null,
	);
	
	protected $fieldDefinitions = array(
		'city_id' => array(
			'db_column_name' => 'city_id',
			'is_null_allowed' => false,
			'default_value' => null
		),
		'short_name' => array(
			'db_column_name' => 'short_name',
			'is_null_allowed' => false,
			'default_value' => null
		),
		'long_name' => array(
			'db_column_name' => 'long_name',
			'is_null_allowed' => false,
			'default_value' => null
		),
		'state' => array(
			'db_column_name' => 'state',
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
		'is_deleted' => array(
			'db_column_name' => 'is_deleted',
			'is_null_allowed' => false,
			'default_value' => null
		),
	);
	
	protected $objectDefinitions = array();
	
	// Static Definition Methods
	
	public static function getDb() {
		if (is_null(City::$db)) {
			City::$db = CoughDatabaseFactory::getDatabase(City::$dbName);
		}
		return City::$db;
	}
	
	public static function getDbName() {
		return CoughDatabaseFactory::getDatabaseName(City::$dbName);
	}
	
	public static function getTableName() {
		return City::$tableName;
	}
	
	public static function getPkFieldNames() {
		return City::$pkFieldNames;
	}
	
	// Static Construction (factory) Methods
	
	/**
	 * Constructs a new City object from
	 * a single id (for single key PKs) or a hash of [field_name] => [field_value].
	 * 
	 * The key is used to pull data from the database, and, if no data is found,
	 * null is returned. You can use this function with any unique keys or the
	 * primary key as long as a hash is used. If the primary key is a single
	 * field, you may pass its value in directly without using a hash.
	 * 
	 * @param mixed $idOrHash - id or hash of [field_name] => [field_value]
	 * @return mixed - City or null if no record found.
	 **/
	public static function constructByKey($idOrHash, $forPhp5Strict = '') {
		return CoughObject::constructByKey($idOrHash, 'City');
	}
	
	/**
	 * Constructs a new City object from custom SQL.
	 * 
	 * @param string $sql
	 * @return mixed - City or null if exactly one record could not be found.
	 **/
	public static function constructBySql($sql, $forPhp5Strict = '') {
		return CoughObject::constructBySql($sql, 'City');
	}
	
	/**
	 * Constructs a new City object after
	 * checking the fields array to make sure the appropriate subclass is
	 * used.
	 * 
	 * No queries are run against the database.
	 * 
	 * @param array $hash - hash of [field_name] => [field_value] pairs
	 * @return City
	 **/
	public static function constructByFields($hash) {
		return new City($hash);
	}
	
	public static function getLoadSql() {
		$tableName = City::getTableName();
		return '
			SELECT
				`' . $tableName . '`.*
			FROM
				`' . City::getDbName() . '`.`' . $tableName . '`
		';
	}
	
	// Generated attribute accessors (getters and setters)
	
	public function getCityId() {
		return $this->getField('city_id');
	}
	
	public function setCityId($value) {
		$this->setField('city_id', $value);
	}
	
	public function getShortName() {
		return $this->getField('short_name');
	}
	
	public function setShortName($value) {
		$this->setField('short_name', $value);
	}
	
	public function getLongName() {
		return $this->getField('long_name');
	}
	
	public function setLongName($value) {
		$this->setField('long_name', $value);
	}
	
	public function getState() {
		return $this->getField('state');
	}
	
	public function setState($value) {
		$this->setField('state', $value);
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
	
	// Generated one-to-many collection loaders, getters, setters, adders, and removers
	
}

?>