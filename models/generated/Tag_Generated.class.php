<?php

/**
 * This is the base class for Tag.
 * 
 * @see Tag, CoughObject
 **/
abstract class Tag_Generated extends AppCoughObject {
	
	protected static $db = null;
	protected static $dbName = 'evently';
	protected static $tableName = 'tag';
	protected static $pkFieldNames = array('tag_id');
	
	protected $fields = array(
		'tag_id' => null,
		'name' => null,
		'date_created' => null,
		'date_modified' => null,
		'is_deleted' => null,
	);
	
	protected $fieldDefinitions = array(
		'tag_id' => array(
			'db_column_name' => 'tag_id',
			'is_null_allowed' => false,
			'default_value' => null
		),
		'name' => array(
			'db_column_name' => 'name',
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
			'default_value' => null
		),
	);
	
	protected $objectDefinitions = array();
	
	// Static Definition Methods
	
	public static function getDb() {
		if (is_null(Tag::$db)) {
			Tag::$db = CoughDatabaseFactory::getDatabase(Tag::$dbName);
		}
		return Tag::$db;
	}
	
	public static function getDbName() {
		return CoughDatabaseFactory::getDatabaseName(Tag::$dbName);
	}
	
	public static function getTableName() {
		return Tag::$tableName;
	}
	
	public static function getPkFieldNames() {
		return Tag::$pkFieldNames;
	}
	
	// Static Construction (factory) Methods
	
	/**
	 * Constructs a new Tag object from
	 * a single id (for single key PKs) or a hash of [field_name] => [field_value].
	 * 
	 * The key is used to pull data from the database, and, if no data is found,
	 * null is returned. You can use this function with any unique keys or the
	 * primary key as long as a hash is used. If the primary key is a single
	 * field, you may pass its value in directly without using a hash.
	 * 
	 * @param mixed $idOrHash - id or hash of [field_name] => [field_value]
	 * @return mixed - Tag or null if no record found.
	 **/
	public static function constructByKey($idOrHash, $forPhp5Strict = '') {
		return CoughObject::constructByKey($idOrHash, 'Tag');
	}
	
	/**
	 * Constructs a new Tag object from custom SQL.
	 * 
	 * @param string $sql
	 * @return mixed - Tag or null if exactly one record could not be found.
	 **/
	public static function constructBySql($sql, $forPhp5Strict = '') {
		return CoughObject::constructBySql($sql, 'Tag');
	}
	
	/**
	 * Constructs a new Tag object after
	 * checking the fields array to make sure the appropriate subclass is
	 * used.
	 * 
	 * No queries are run against the database.
	 * 
	 * @param array $hash - hash of [field_name] => [field_value] pairs
	 * @return Tag
	 **/
	public static function constructByFields($hash) {
		return new Tag($hash);
	}
	
	public static function getLoadSql() {
		$tableName = Tag::getTableName();
		return '
			SELECT
				`' . $tableName . '`.*
			FROM
				`' . Tag::getDbName() . '`.`' . $tableName . '`
		';
	}
	
	// Generated attribute accessors (getters and setters)
	
	public function getTagId() {
		return $this->getField('tag_id');
	}
	
	public function setTagId($value) {
		$this->setField('tag_id', $value);
	}
	
	public function getName() {
		return $this->getField('name');
	}
	
	public function setName($value) {
		$this->setField('name', $value);
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