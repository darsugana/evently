<?php

/**
 * This is the base class for User.
 * 
 * @see User, CoughObject
 **/
abstract class User_Generated extends AppCoughObject {
	
	protected static $db = null;
	protected static $dbName = 'evently';
	protected static $tableName = 'user';
	protected static $pkFieldNames = array('user_id');
	
	protected $fields = array(
		'user_id' => null,
		'facebook_uid' => null,
		'email' => null,
		'is_deleted' => null,
		'date_created' => null,
		'date_modified' => null,
	);
	
	protected $fieldDefinitions = array(
		'user_id' => array(
			'db_column_name' => 'user_id',
			'is_null_allowed' => false,
			'default_value' => null
		),
		'facebook_uid' => array(
			'db_column_name' => 'facebook_uid',
			'is_null_allowed' => true,
			'default_value' => null
		),
		'email' => array(
			'db_column_name' => 'email',
			'is_null_allowed' => true,
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
	
	protected $objectDefinitions = array();
	
	// Static Definition Methods
	
	public static function getDb() {
		if (is_null(User::$db)) {
			User::$db = CoughDatabaseFactory::getDatabase(User::$dbName);
		}
		return User::$db;
	}
	
	public static function getDbName() {
		return CoughDatabaseFactory::getDatabaseName(User::$dbName);
	}
	
	public static function getTableName() {
		return User::$tableName;
	}
	
	public static function getPkFieldNames() {
		return User::$pkFieldNames;
	}
	
	// Static Construction (factory) Methods
	
	/**
	 * Constructs a new User object from
	 * a single id (for single key PKs) or a hash of [field_name] => [field_value].
	 * 
	 * The key is used to pull data from the database, and, if no data is found,
	 * null is returned. You can use this function with any unique keys or the
	 * primary key as long as a hash is used. If the primary key is a single
	 * field, you may pass its value in directly without using a hash.
	 * 
	 * @param mixed $idOrHash - id or hash of [field_name] => [field_value]
	 * @return mixed - User or null if no record found.
	 **/
	public static function constructByKey($idOrHash, $forPhp5Strict = '') {
		return CoughObject::constructByKey($idOrHash, 'User');
	}
	
	/**
	 * Constructs a new User object from custom SQL.
	 * 
	 * @param string $sql
	 * @return mixed - User or null if exactly one record could not be found.
	 **/
	public static function constructBySql($sql, $forPhp5Strict = '') {
		return CoughObject::constructBySql($sql, 'User');
	}
	
	/**
	 * Constructs a new User object after
	 * checking the fields array to make sure the appropriate subclass is
	 * used.
	 * 
	 * No queries are run against the database.
	 * 
	 * @param array $hash - hash of [field_name] => [field_value] pairs
	 * @return User
	 **/
	public static function constructByFields($hash) {
		return new User($hash);
	}
	
	public static function getLoadSql() {
		$tableName = User::getTableName();
		return '
			SELECT
				`' . $tableName . '`.*
			FROM
				`' . User::getDbName() . '`.`' . $tableName . '`
		';
	}
	
	// Generated attribute accessors (getters and setters)
	
	public function getUserId() {
		return $this->getField('user_id');
	}
	
	public function setUserId($value) {
		$this->setField('user_id', $value);
	}
	
	public function getFacebookUid() {
		return $this->getField('facebook_uid');
	}
	
	public function setFacebookUid($value) {
		$this->setField('facebook_uid', $value);
	}
	
	public function getEmail() {
		return $this->getField('email');
	}
	
	public function setEmail($value) {
		$this->setField('email', $value);
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
	
	// Generated one-to-many collection loaders, getters, setters, adders, and removers
	
}

?>