<?php

/**
 * This is the base class for Source.
 * 
 * @see Source, CoughObject
 **/
abstract class Source_Generated extends AppCoughObject {
	
	protected static $db = null;
	protected static $dbName = 'evently';
	protected static $tableName = 'source';
	protected static $pkFieldNames = array('source_id');
	
	protected $fields = array(
		'source_id' => null,
		'name' => null,
		'feed' => null,
		'city_id' => null,
		'source_group_id' => null,
		'date_modified' => null,
		'date_created' => null,
		'is_deleted' => 0,
	);
	
	protected $fieldDefinitions = array(
		'source_id' => array(
			'db_column_name' => 'source_id',
			'is_null_allowed' => false,
			'default_value' => null
		),
		'name' => array(
			'db_column_name' => 'name',
			'is_null_allowed' => false,
			'default_value' => null
		),
		'feed' => array(
			'db_column_name' => 'feed',
			'is_null_allowed' => false,
			'default_value' => null
		),
		'city_id' => array(
			'db_column_name' => 'city_id',
			'is_null_allowed' => true,
			'default_value' => null
		),
		'source_group_id' => array(
			'db_column_name' => 'source_group_id',
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
			'is_null_allowed' => false,
			'default_value' => null
		),
		'is_deleted' => array(
			'db_column_name' => 'is_deleted',
			'is_null_allowed' => false,
			'default_value' => 0
		),
	);
	
	protected $objectDefinitions = array(
		'City_Object' => array(
			'class_name' => 'City'
		),
		'SourceGroup_Object' => array(
			'class_name' => 'SourceGroup'
		),
	);
	
	// Static Definition Methods
	
	public static function getDb() {
		if (is_null(Source::$db)) {
			Source::$db = CoughDatabaseFactory::getDatabase(Source::$dbName);
		}
		return Source::$db;
	}
	
	public static function getDbName() {
		return CoughDatabaseFactory::getDatabaseName(Source::$dbName);
	}
	
	public static function getTableName() {
		return Source::$tableName;
	}
	
	public static function getPkFieldNames() {
		return Source::$pkFieldNames;
	}
	
	// Static Construction (factory) Methods
	
	/**
	 * Constructs a new Source object from
	 * a single id (for single key PKs) or a hash of [field_name] => [field_value].
	 * 
	 * The key is used to pull data from the database, and, if no data is found,
	 * null is returned. You can use this function with any unique keys or the
	 * primary key as long as a hash is used. If the primary key is a single
	 * field, you may pass its value in directly without using a hash.
	 * 
	 * @param mixed $idOrHash - id or hash of [field_name] => [field_value]
	 * @return mixed - Source or null if no record found.
	 **/
	public static function constructByKey($idOrHash, $forPhp5Strict = '') {
		return CoughObject::constructByKey($idOrHash, 'Source');
	}
	
	/**
	 * Constructs a new Source object from custom SQL.
	 * 
	 * @param string $sql
	 * @return mixed - Source or null if exactly one record could not be found.
	 **/
	public static function constructBySql($sql, $forPhp5Strict = '') {
		return CoughObject::constructBySql($sql, 'Source');
	}
	
	/**
	 * Constructs a new Source object after
	 * checking the fields array to make sure the appropriate subclass is
	 * used.
	 * 
	 * No queries are run against the database.
	 * 
	 * @param array $hash - hash of [field_name] => [field_value] pairs
	 * @return Source
	 **/
	public static function constructByFields($hash) {
		return new Source($hash);
	}
	
	public static function getLoadSql() {
		$tableName = Source::getTableName();
		return '
			SELECT
				`' . $tableName . '`.*
			FROM
				`' . Source::getDbName() . '`.`' . $tableName . '`
		';
	}
	
	// Generated attribute accessors (getters and setters)
	
	public function getSourceId() {
		return $this->getField('source_id');
	}
	
	public function setSourceId($value) {
		$this->setField('source_id', $value);
	}
	
	public function getName() {
		return $this->getField('name');
	}
	
	public function setName($value) {
		$this->setField('name', $value);
	}
	
	public function getFeed() {
		return $this->getField('feed');
	}
	
	public function setFeed($value) {
		$this->setField('feed', $value);
	}
	
	public function getCityId() {
		return $this->getField('city_id');
	}
	
	public function setCityId($value) {
		$this->setField('city_id', $value);
	}
	
	public function getSourceGroupId() {
		return $this->getField('source_group_id');
	}
	
	public function setSourceGroupId($value) {
		$this->setField('source_group_id', $value);
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
	
	public function loadCity_Object() {
		$this->setCity_Object(City::constructByKey($this->getCityId()));
	}
	
	public function getCity_Object() {
		if (!isset($this->objects['City_Object'])) {
			$this->loadCity_Object();
		}
		return $this->objects['City_Object'];
	}
	
	public function setCity_Object($city) {
		$this->objects['City_Object'] = $city;
	}
	
	public function loadSourceGroup_Object() {
		$this->setSourceGroup_Object(SourceGroup::constructByKey($this->getSourceGroupId()));
	}
	
	public function getSourceGroup_Object() {
		if (!isset($this->objects['SourceGroup_Object'])) {
			$this->loadSourceGroup_Object();
		}
		return $this->objects['SourceGroup_Object'];
	}
	
	public function setSourceGroup_Object($sourceGroup) {
		$this->objects['SourceGroup_Object'] = $sourceGroup;
	}
	
	// Generated one-to-many collection loaders, getters, setters, adders, and removers
	
}

?>