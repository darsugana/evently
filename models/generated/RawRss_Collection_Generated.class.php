<?php

/**
 * This is the base class for RawRss_Collection.
 *
 * @see RawRss_Collection, CoughCollection
 **/
abstract class RawRss_Collection_Generated extends AppCoughCollection {
	protected $dbAlias = 'events';
	protected $dbName = 'events';
	protected $elementClassName = 'RawRss';
}

?>