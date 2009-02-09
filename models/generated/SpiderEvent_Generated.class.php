<?php

/**
 * This is the base class for SpiderEvent.
 * 
 * @see SpiderEvent, CoughObject
 **/
abstract class SpiderEvent_Generated extends AppCoughObject {
	
	protected static $db = null;
	protected static $dbName = 'evently';
	protected static $tableName = 'spider_event';
	protected static $pkFieldNames = array('spider_event_id');
	
	protected $fields = array(
		'spider_event_id' => null,
		'source_id' => null,
		'raw_rss_id' => null,
		'spider_status_id' => null,
		'date_created' => null,
		'date_modified' => null,
		'is_deleted' => null,
	);
	
	protected $fieldDefinitions = array(
		'spider_event_id' => array(
			'db_column_name' => 'spider_event_id',
			'is_null_allowed' => false,
			'default_value' => null
		),
		'source_id' => array(
			'db_column_name' => 'source_id',
			'is_null_allowed' => false,
			'default_value' => null
		),
		'raw_rss_id' => array(
			'db_column_name' => 'raw_rss_id',
			'is_null_allowed' => true,
			'default_value' => null
		),
		'spider_status_id' => array(
			'db_column_name' => 'spider_status_id',
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
	
	protected $objectDefinitions = array(
		'Source_Object' => array(
			'class_name' => 'Source'
		),
		'RawRss_Object' => array(
			'class_name' => 'RawRss'
		),
		'SpiderStatus_Object' => array(
			'class_name' => 'SpiderStatus'
		),
	);
	
	// Static Definition Methods
	
	public static function getDb() {
		if (is_null(SpiderEvent::$db)) {
			SpiderEvent::$db = CoughDatabaseFactory::getDatabase(SpiderEvent::$dbName);
		}
		return SpiderEvent::$db;
	}
	
	public static function getDbName() {
		return CoughDatabaseFactory::getDatabaseName(SpiderEvent::$dbName);
	}
	
	public static function getTableName() {
		return SpiderEvent::$tableName;
	}
	
	public static function getPkFieldNames() {
		return SpiderEvent::$pkFieldNames;
	}
	
	// Static Construction (factory) Methods
	
	/**
	 * Constructs a new SpiderEvent object from
	 * a single id (for single key PKs) or a hash of [field_name] => [field_value].
	 * 
	 * The key is used to pull data from the database, and, if no data is found,
	 * null is returned. You can use this function with any unique keys or the
	 * primary key as long as a hash is used. If the primary key is a single
	 * field, you may pass its value in directly without using a hash.
	 * 
	 * @param mixed $idOrHash - id or hash of [field_name] => [field_value]
	 * @return mixed - SpiderEvent or null if no record found.
	 **/
	public static function constructByKey($idOrHash, $forPhp5Strict = '') {
		return CoughObject::constructByKey($idOrHash, 'SpiderEvent');
	}
	
	/**
	 * Constructs a new SpiderEvent object from custom SQL.
	 * 
	 * @param string $sql
	 * @return mixed - SpiderEvent or null if exactly one record could not be found.
	 **/
	public static function constructBySql($sql, $forPhp5Strict = '') {
		return CoughObject::constructBySql($sql, 'SpiderEvent');
	}
	
	/**
	 * Constructs a new SpiderEvent object after
	 * checking the fields array to make sure the appropriate subclass is
	 * used.
	 * 
	 * No queries are run against the database.
	 * 
	 * @param array $hash - hash of [field_name] => [field_value] pairs
	 * @return SpiderEvent
	 **/
	public static function constructByFields($hash) {
		return new SpiderEvent($hash);
	}
	
	public static function getLoadSql() {
		$tableName = SpiderEvent::getTableName();
		return '
			SELECT
				`' . $tableName . '`.*
			FROM
				`' . SpiderEvent::getDbName() . '`.`' . $tableName . '`
		';
	}
	
	// Generated attribute accessors (getters and setters)
	
	public function getSpiderEventId() {
		return $this->getField('spider_event_id');
	}
	
	public function setSpiderEventId($value) {
		$this->setField('spider_event_id', $value);
	}
	
	public function getSourceId() {
		return $this->getField('source_id');
	}
	
	public function setSourceId($value) {
		$this->setField('source_id', $value);
	}
	
	public function getRawRssId() {
		return $this->getField('raw_rss_id');
	}
	
	public function setRawRssId($value) {
		$this->setField('raw_rss_id', $value);
	}
	
	public function getSpiderStatusId() {
		return $this->getField('spider_status_id');
	}
	
	public function setSpiderStatusId($value) {
		$this->setField('spider_status_id', $value);
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
	
	public function loadRawRss_Object() {
		$this->setRawRss_Object(RawRss::constructByKey($this->getRawRssId()));
	}
	
	public function getRawRss_Object() {
		if (!isset($this->objects['RawRss_Object'])) {
			$this->loadRawRss_Object();
		}
		return $this->objects['RawRss_Object'];
	}
	
	public function setRawRss_Object($rawRss) {
		$this->objects['RawRss_Object'] = $rawRss;
	}
	
	public function loadSpiderStatus_Object() {
		$this->setSpiderStatus_Object(SpiderStatus::constructByKey($this->getSpiderStatusId()));
	}
	
	public function getSpiderStatus_Object() {
		if (!isset($this->objects['SpiderStatus_Object'])) {
			$this->loadSpiderStatus_Object();
		}
		return $this->objects['SpiderStatus_Object'];
	}
	
	public function setSpiderStatus_Object($spiderStatus) {
		$this->objects['SpiderStatus_Object'] = $spiderStatus;
	}
	
	// Generated one-to-many collection loaders, getters, setters, adders, and removers
	
}

?>