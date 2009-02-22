<?php
/**
 * Default DatabaseSchemaGenerator configuration options.
 * 
 * You don't have to pass these to the schema generator as it will use
 * reasonable defaults. The are replicated here to make them easy to change.
 *
 * @package CoughPHP
 * @author Anthony Bush
 **/


$config = array(
	// REQUIRED CONFIG
	
	// All databases will be scanned unless specified in the 'databases' parameter in the OPTIONAL CONFIG SECTION.
	'dsn' => array(
		'host' => '127.0.0.1',
		'user' => 'evently',
		'pass' => '3v3ntlyr0cks2!',
		'port' => 3306,
		'driver' => 'mysql'
	),
	
	// OPTIONAL ADDITIONAL CONFIG
	
	'database_settings' => array(
		'include_databases_matching_regex' => '/
			# is exactly
			^(
				evently
			)$
		/x' // x modififer => white space is ignored (so we can format for readability)
	),
	
	'field_settings' => array(
		// In case of non FK detection, you can have the Database Schema Generator check for ID columns matching this regex.
		// This is useful, for example, when no FK relationships set up). The first parenthesis match will be used to search
		// for tables
		'id_to_table_regex' => array(
			'/^default_billing_(.*)_id$/',
			'/^default_shipping_(.*)_id$/',
			'/^billing_(.*)_id$/',
			'/^shipping_(.*)_id$/',
			'/^parent_(.*)_id$/',
			'/^child_(.*)_id$/',
			'/^contact_(.*)_id$/',
			'/^primary_(.*)_id/',
			'/^default_(.*)_id/',
			'/^(.*)_id/'
		),
	),	
);

?>
