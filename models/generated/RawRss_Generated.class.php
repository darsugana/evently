<?php

/**
 * This is the base class for RawRss.
 * 
 * @see RawRss, CoughObject
 **/
abstract class RawRss_Generated extends AppCoughObject {
	
	protected static $db = null;
	protected static $dbName = 'events';
	protected static $tableName = 'raw_rss';
	protected static $pkFieldNames = array('raw_rss_id');
	
	protected $fields = array(
		'raw_rss_id' => null,
		'source_id' => null,
		'raw_rss_data' => null,
		'date_modified' => null,
		'date_created' => null,
		'is_deleted' => 0,
	);
	
	protected $fieldDefinitions = array(
		'raw_rss_id' => array(
			'db_column_name' => 'raw_rss_id',
			'is_null_allowed' => false,
			'default_value' => null
		),
		'source_id' => array(
			'db_column_name' => 'source_id',
			'is_null_allowed' => false,
			'default_value' => null
		),
		'raw_rss_data' => array(
			'db_column_name' => 'raw_rss_data',
			'is_null_allowed' => false,
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
	
	protected $objectDefinitions = array(
		'Source_Object' => array(
			'class_name' => 'Source'
		),
	);
	
	// Static Definition Methods
	
	public static function getDb() {
		if (is_null(RawRss::$db)) {
			RawRss::$db = CoughDatabaseFactory::getDatabase(RawRss::$dbName);
		}
		return RawRss::$db;
	}
	
	public static function getDbName() {
		return CoughDatabaseFactory::getDatabaseName(RawRss::$dbName);
	}
	
	public static function getTableName() {
		return RawRss::$tableName;
	}
	
	public static function getPkFieldNames() {
		return RawRss::$pkFieldNames;
	}
	
	// Static Construction (factory) Methods
	
	/**
	 * Constructs a new RawRss object from
	 * a single id (for single key PKs) or a hash of [field_name] => [field_value].
	 * 
	 * The key is used to pull data from the database, and, if no data is found,
	 * null is returned. You can use this function with any unique keys or the
	 * primary key as long as a hash is used. If the primary key is a single
	 * field, you may pass its value in directly without using a hash.
	 * 
	 * @param mixed $idOrHash - id or hash of [field_name] => [field_value]
	 * @return mixed - RawRss or null if no record found.
	 **/
	public static function constructByKey($idOrHash, $forPhp5Strict = '') {
		return CoughObject::constructByKey($idOrHash, 'RawRss');
	}
	
	/**
	 * Constructs a new RawRss object from custom SQL.
	 * 
	 * @param string $sql
	 * @return mixed - RawRss or null if exactly one record could not be found.
	 **/
	public static function constructBySql($sql, $forPhp5Strict = '') {
		return CoughObject::constructBySql($sql, 'RawRss');
	}
	
	/**
	 * Constructs a new RawRss object after
	 * checking the fields array to make sure the appropriate subclass is
	 * used.
	 * 
	 * No queries are run against the database.
	 * 
	 * @param array $hash - hash of [field_name] => [field_value] pairs
	 * @return RawRss
	 **/
	public static function constructByFields($hash) {
		return new RawRss($hash);
	}
	
	public static function getLoadSql() {
		$tableName = RawRss::getTableName();
		return '
			SELECT
				`' . $tableName . '`.*
			FROM
				`' . RawRss::getDbName() . '`.`' . $tableName . '`
		';
	}
	
	// Generated attribute accessors (getters and setters)
	
	public function getRawRssId() {
		return $this->getField('raw_rss_id');
	}
	
	public function setRawRssId($value) {
		$this->setField('raw_rss_id', $value);
	}
	
	public function getSourceId() {
		return $this->getField('source_id');
	}
	
	public function setSourceId($value) {
		$this->setField('source_id', $value);
	}
	
	public function getRawRssData() {
		return $this->getField('raw_rss_data');
	}
	
	public function setRawRssData($value) {
		$this->setField('raw_rss_data', $value);
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
	
	public function loadSource_Object() {
		$this->setSource_Object(Source::constructByKey($this->getSourceId()));
	}
	
	public function getSource_Object() {
		if (!isset($this->objects['Source_Object'])) {
			$this->loadSource_Object();
		}
		return $this->objects['Source_Object'];
	}
	
	public function setSource_Object($source) {
		$this->objects['Source_Object'] = $source;
	}
	
	// Generated one-to-many collection loaders, getters, setters, adders, and removers
	
}

?>