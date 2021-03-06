<?php

/**
 * This is the base class for Event.
 * 
 * @see Event, CoughObject
 **/
abstract class Event_Generated extends AppCoughObject {
	
	protected static $db = null;
	protected static $dbName = 'evently';
	protected static $tableName = 'event';
	protected static $pkFieldNames = array('event_id');
	
	protected $fields = array(
		'event_id' => null,
		'source_id' => null,
		'raw_rss_id' => null,
		'raw_html_id' => null,
		'name' => null,
		'description' => null,
		'date' => null,
		'all_day_event' => null,
		'guid' => null,
		'link' => null,
		'latitude' => null,
		'longitude' => null,
		'venue_id' => null,
		'city_id' => null,
		'category_id' => null,
		'vote_total' => null,
		'rsvp_total' => null,
		'date_published' => null,
		'date_modified' => null,
		'date_created' => null,
		'is_deleted' => 0,
	);
	
	protected $fieldDefinitions = array(
		'event_id' => array(
			'db_column_name' => 'event_id',
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
			'is_null_allowed' => false,
			'default_value' => null
		),
		'raw_html_id' => array(
			'db_column_name' => 'raw_html_id',
			'is_null_allowed' => true,
			'default_value' => null
		),
		'name' => array(
			'db_column_name' => 'name',
			'is_null_allowed' => false,
			'default_value' => null
		),
		'description' => array(
			'db_column_name' => 'description',
			'is_null_allowed' => false,
			'default_value' => null
		),
		'date' => array(
			'db_column_name' => 'date',
			'is_null_allowed' => false,
			'default_value' => null
		),
		'all_day_event' => array(
			'db_column_name' => 'all_day_event',
			'is_null_allowed' => false,
			'default_value' => null
		),
		'guid' => array(
			'db_column_name' => 'guid',
			'is_null_allowed' => false,
			'default_value' => null
		),
		'link' => array(
			'db_column_name' => 'link',
			'is_null_allowed' => false,
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
		'venue_id' => array(
			'db_column_name' => 'venue_id',
			'is_null_allowed' => true,
			'default_value' => null
		),
		'city_id' => array(
			'db_column_name' => 'city_id',
			'is_null_allowed' => true,
			'default_value' => null
		),
		'category_id' => array(
			'db_column_name' => 'category_id',
			'is_null_allowed' => true,
			'default_value' => null
		),
		'vote_total' => array(
			'db_column_name' => 'vote_total',
			'is_null_allowed' => false,
			'default_value' => null
		),
		'rsvp_total' => array(
			'db_column_name' => 'rsvp_total',
			'is_null_allowed' => false,
			'default_value' => null
		),
		'date_published' => array(
			'db_column_name' => 'date_published',
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
		'Source_Object' => array(
			'class_name' => 'Source'
		),
		'RawRss_Object' => array(
			'class_name' => 'RawRss'
		),
		'RawHtml_Object' => array(
			'class_name' => 'RawHtml'
		),
		'Venue_Object' => array(
			'class_name' => 'Venue'
		),
		'City_Object' => array(
			'class_name' => 'City'
		),
		'Category_Object' => array(
			'class_name' => 'Category'
		),
	);
	
	// Static Definition Methods
	
	public static function getDb() {
		if (is_null(Event::$db)) {
			Event::$db = CoughDatabaseFactory::getDatabase(Event::$dbName);
		}
		return Event::$db;
	}
	
	public static function getDbName() {
		return CoughDatabaseFactory::getDatabaseName(Event::$dbName);
	}
	
	public static function getTableName() {
		return Event::$tableName;
	}
	
	public static function getPkFieldNames() {
		return Event::$pkFieldNames;
	}
	
	// Static Construction (factory) Methods
	
	/**
	 * Constructs a new Event object from
	 * a single id (for single key PKs) or a hash of [field_name] => [field_value].
	 * 
	 * The key is used to pull data from the database, and, if no data is found,
	 * null is returned. You can use this function with any unique keys or the
	 * primary key as long as a hash is used. If the primary key is a single
	 * field, you may pass its value in directly without using a hash.
	 * 
	 * @param mixed $idOrHash - id or hash of [field_name] => [field_value]
	 * @return mixed - Event or null if no record found.
	 **/
	public static function constructByKey($idOrHash, $forPhp5Strict = '') {
		return CoughObject::constructByKey($idOrHash, 'Event');
	}
	
	/**
	 * Constructs a new Event object from custom SQL.
	 * 
	 * @param string $sql
	 * @return mixed - Event or null if exactly one record could not be found.
	 **/
	public static function constructBySql($sql, $forPhp5Strict = '') {
		return CoughObject::constructBySql($sql, 'Event');
	}
	
	/**
	 * Constructs a new Event object after
	 * checking the fields array to make sure the appropriate subclass is
	 * used.
	 * 
	 * No queries are run against the database.
	 * 
	 * @param array $hash - hash of [field_name] => [field_value] pairs
	 * @return Event
	 **/
	public static function constructByFields($hash) {
		return new Event($hash);
	}
	
	public static function getLoadSql() {
		$tableName = Event::getTableName();
		return '
			SELECT
				`' . $tableName . '`.*
			FROM
				`' . Event::getDbName() . '`.`' . $tableName . '`
		';
	}
	
	// Generated attribute accessors (getters and setters)
	
	public function getEventId() {
		return $this->getField('event_id');
	}
	
	public function setEventId($value) {
		$this->setField('event_id', $value);
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
	
	public function getRawHtmlId() {
		return $this->getField('raw_html_id');
	}
	
	public function setRawHtmlId($value) {
		$this->setField('raw_html_id', $value);
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
	
	public function getDate() {
		return $this->getField('date');
	}
	
	public function setDate($value) {
		$this->setField('date', $value);
	}
	
	public function getAllDayEvent() {
		return $this->getField('all_day_event');
	}
	
	public function setAllDayEvent($value) {
		$this->setField('all_day_event', $value);
	}
	
	public function getGuid() {
		return $this->getField('guid');
	}
	
	public function setGuid($value) {
		$this->setField('guid', $value);
	}
	
	public function getLink() {
		return $this->getField('link');
	}
	
	public function setLink($value) {
		$this->setField('link', $value);
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
	
	public function getVenueId() {
		return $this->getField('venue_id');
	}
	
	public function setVenueId($value) {
		$this->setField('venue_id', $value);
	}
	
	public function getCityId() {
		return $this->getField('city_id');
	}
	
	public function setCityId($value) {
		$this->setField('city_id', $value);
	}
	
	public function getCategoryId() {
		return $this->getField('category_id');
	}
	
	public function setCategoryId($value) {
		$this->setField('category_id', $value);
	}
	
	public function getVoteTotal() {
		return $this->getField('vote_total');
	}
	
	public function setVoteTotal($value) {
		$this->setField('vote_total', $value);
	}
	
	public function getRsvpTotal() {
		return $this->getField('rsvp_total');
	}
	
	public function setRsvpTotal($value) {
		$this->setField('rsvp_total', $value);
	}
	
	public function getDatePublished() {
		return $this->getField('date_published');
	}
	
	public function setDatePublished($value) {
		$this->setField('date_published', $value);
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
	
	public function loadRawHtml_Object() {
		$this->setRawHtml_Object(RawHtml::constructByKey($this->getRawHtmlId()));
	}
	
	public function getRawHtml_Object() {
		if (!isset($this->objects['RawHtml_Object'])) {
			$this->loadRawHtml_Object();
		}
		return $this->objects['RawHtml_Object'];
	}
	
	public function setRawHtml_Object($rawHtml) {
		$this->objects['RawHtml_Object'] = $rawHtml;
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
	
	public function loadCategory_Object() {
		$this->setCategory_Object(Category::constructByKey($this->getCategoryId()));
	}
	
	public function getCategory_Object() {
		if (!isset($this->objects['Category_Object'])) {
			$this->loadCategory_Object();
		}
		return $this->objects['Category_Object'];
	}
	
	public function setCategory_Object($category) {
		$this->objects['Category_Object'] = $category;
	}
	
	// Generated one-to-many collection loaders, getters, setters, adders, and removers
	
}

?>