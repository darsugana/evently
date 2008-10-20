<?php

/**
 * This is the base class for SpiderStatus.
 * 
 * @see SpiderStatus, CoughObject
 **/
abstract class SpiderStatus_Generated extends AppCoughObject {
	
	protected static $db = null;
	protected static $dbName = 'evently';
	protected static $tableName = 'spider_status';
	protected static $pkFieldNames = array('spider_status_id');
	
	protected $fields = array(
		'spider_status_id' => null,
		'spider_status' => null,
	);
	
	protected $fieldDefinitions = array(
		'spider_status_id' => array(
			'db_column_name' => 'spider_status_id',
			'is_null_allowed' => false,
			'default_value' => null
		),
		'spider_status' => array(
			'db_column_name' => 'spider_status',
			'is_null_allowed' => false,
			'default_value' => null
		),
	);
	
	protected $objectDefinitions = array();
	
	// Static Definition Methods
	
	public static function getDb() {
		if (is_null(SpiderStatus::$db)) {
			SpiderStatus::$db = CoughDatabaseFactory::getDatabase(SpiderStatus::$dbName);
		}
		return SpiderStatus::$db;
	}
	
	public static function getDbName() {
		return CoughDatabaseFactory::getDatabaseName(SpiderStatus::$dbName);
	}
	
	public static function getTableName() {
		return SpiderStatus::$tableName;
	}
	
	public static function getPkFieldNames() {
		return SpiderStatus::$pkFieldNames;
	}
	
	// Static Construction (factory) Methods
	
	/**
	 * Constructs a new SpiderStatus object from
	 * a single id (for single key PKs) or a hash of [field_name] => [field_value].
	 * 
	 * The key is used to pull data from the database, and, if no data is found,
	 * null is returned. You can use this function with any unique keys or the
	 * primary key as long as a hash is used. If the primary key is a single
	 * field, you may pass its value in directly without using a hash.
	 * 
	 * @param mixed $idOrHash - id or hash of [field_name] => [field_value]
	 * @return mixed - SpiderStatus or null if no record found.
	 **/
	public static function constructByKey($idOrHash, $forPhp5Strict = '') {
		return CoughObject::constructByKey($idOrHash, 'SpiderStatus');
	}
	
	/**
	 * Constructs a new SpiderStatus object from custom SQL.
	 * 
	 * @param string $sql
	 * @return mixed - SpiderStatus or null if exactly one record could not be found.
	 **/
	public static function constructBySql($sql, $forPhp5Strict = '') {
		return CoughObject::constructBySql($sql, 'SpiderStatus');
	}
	
	/**
	 * Constructs a new SpiderStatus object after
	 * checking the fields array to make sure the appropriate subclass is
	 * used.
	 * 
	 * No queries are run against the database.
	 * 
	 * @param array $hash - hash of [field_name] => [field_value] pairs
	 * @return SpiderStatus
	 **/
	public static function constructByFields($hash) {
		return new SpiderStatus($hash);
	}
	
	public static function getLoadSql() {
		$tableName = SpiderStatus::getTableName();
		return '
			SELECT
				`' . $tableName . '`.*
			FROM
				`' . SpiderStatus::getDbName() . '`.`' . $tableName . '`
		';
	}
	
	// Generated attribute accessors (getters and setters)
	
	public function getSpiderStatusId() {
		return $this->getField('spider_status_id');
	}
	
	public function setSpiderStatusId($value) {
		$this->setField('spider_status_id', $value);
	}
	
	public function getSpiderStatus() {
		return $this->getField('spider_status');
	}
	
	public function setSpiderStatus($value) {
		$this->setField('spider_status', $value);
	}
	
	// Generated one-to-one accessors (loaders, getters, and setters)
	
	// Generated one-to-many collection loaders, getters, setters, adders, and removers
	
}

?>