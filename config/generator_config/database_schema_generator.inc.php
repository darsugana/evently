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
		'user' => 'root',
		'pass' => '',
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
	
	'table_settings' => array(
		// This match setting is so the database scanner can resolve relationships better, e.g. know that when it sees "ticket_id" that a "wfl_ticket" table is an acceptable match.
		'match_table_name_prefixes' => array('cust_','wfl_','baof_','inv_'),
		
		'include_tables_matching_regex' => '/.*/',
		
		// CAUTION: IF YOU ARE UPDATING "exclude_tables_matching_regex" CHECK TO MAKE
		// SURE THE DATABASE THE TABLE IS IN HASN'T OVERRIDEN THIS SETTING.
		// TODO: leave the bak_, etc. rules here but move all the explicit table checks
		// into the database settings' sections.
		'exclude_tables_matching_regex' => '/
			# starts with
			(^(bak_|temp_|tmp_|test_))
			
			# or ends with
			| ((_bak|_backup|_temp|_tmp|_deprecated)$)
			
			# or is exactly
			| ^(
				account_rank
				| bargain_line
				| baof_eligibility
				| ccategory2product_copy
				| ccategory_copy
				| cust_address_match_key_deprecated
				| cust_address_normalized
				| cust_address_normalize_error
				| cust_institution_normalized_my
				| customer_view
				| display_category2ccategory_copy
				| estimated_product_cost
				| forecast_inventory
				| forecast_order_history
				| forecast_product
				| forecast_purchasing
				| inventory_summary
				| log_retire
				| order2eligibility
				| order_item
				| order_status
				| price_group_manufacturer_pricing
				| price_group_pricing
				| product_demand
				| product_price
				| product_price2
				| ranktable
				| state_paypal
				| store_manufacturer_pricing
				| vendor_min_cost
			)$
		/x', // x modififer => white space is ignored (so we can format for readability)
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
	
	// Override config for some of the databases
	'databases' => array(
		'content3' => array(
			'acceptable_join_databases' => array('content3', 'customer', 'inventory', 'superstore', 'user', 'vendor_import'),
			'tables' => array(
				'product_extended' => array(
					'primary_key' => array('product_id', 'locale_id'),
				),
			),
		),
		'crm' => array(
			'acceptable_join_databases' => array(),
		),
		'customer' => array(
			'tables' => array(
				'cust_address_preferred' => array(
					'primary_key' => 'address_id',
				),
			),
		),
		'gradware' => array(
			// Make sure that gradware joins for customer records link to gradware_customer database and not customer
			'acceptable_join_databases' => array('content3', 'gradware', 'gradware_customer', 'inventory', 'superstore', 'user', 'vendor_import'),
		),
		'gradware_customer' => array(
			// Make sure that gradware_customer joins for customer records link to gradware_customer database and not customer
			'acceptable_join_databases' => array('content3', 'gradware', 'gradware_customer', 'inventory', 'superstore', 'user', 'vendor_import'),
		),
		'mdr' => array(
			'acceptable_join_databases' => array('mdr'),
			'table_settings' => array(
				'exclude_tables_matching_regex' => '/
					# starts with
					(^(bak_|temp_|tmp_|test_))
					
					# or ends with
					|((_bak|_backup|_temp|_deprecated)$)
					
					# or is exactly
					| ^(
						BIASCH
						| CANDIST
						| CANPRIV
						| CANSCH
						| CATSCH
						| CNTYCTR
						| CNTYSCH
						| COLLEGE
						| DAYCARE
						| DIOCESE
						| HEADER
						| LIBRARY
						| PRIVSCH
						| PUBDIST
						| PUBSCH
						| REGCTR
						| USSTDEPT
						| USSTSCH
					)$
				/x', // x modififer => white space is ignored (so we can format for readability)
			),
		),
		'new_user' => array(
			'acceptable_join_databases' => array('content3', 'customer', 'new_user', 'inventory', 'superstore', 'user', 'vendor_import'),
			'table_settings' => array(
				'exclude_tables_matching_regex' => '/
					# starts with
					(^(bak_|temp_|tmp_|test_))
					
					# or ends with
					|((_bak|_backup|_temp|_deprecated)$)
					
					# or is exactly
					| ^(
						cust_address_match_key_deprecated
						| address
						| bargain_line
						| ccategory2product_copy
						| ccategory_copy
						| country
						| customer
						| customer_type
						| cust_address_normalized
						| cust_address_normalize_error
						| display_category2ccategory_copy
						| eligibility
						| email
						| order2eligibility
						| order_item
						| order_status
						| phone
						| state
						| wfl_customer_type
					)$
				/x', // x modififer => white space is ignored (so we can format for readability)
			),
		),
		'superstore' => array(
			'acceptable_join_databases' => array('superstore'), // only generate collection methods to tables in the same database.
			'tables' => array(
				'store' => array(
					'acceptable_join_databases' => array('superstore', 'content3'),
				),
				'tax_rule' => array(
					'acceptable_join_databases' => array('superstore', 'content3'),
				),
				'company2brand' => array(
					'acceptable_join_databases' => array('superstore', 'vendor_import'),
				),
			),
		),
		'marketing' => array(
			'acceptable_join_databases' => array(),
		),
		'messages' => array(
			'acceptable_join_databases' => array(),
		),
		'gw_events' => array(
			'acceptable_join_databases' => array(),
		),
		'user' => array(
			'acceptable_join_databases' => array('content3', 'customer', 'superstore', 'user', 'vendor_import'),
			'table_settings' => array(
				// Override table exclusion rules for this database...
				'exclude_tables_matching_regex' => '/
					# starts with
					(^(bak_|temp_|tmp_|test_))

					# or ends with
					| ((_bak|_backup|_temp|_tmp|_deprecated)$)

					# or is exactly
					| ^(
						account_rank
						| bargain_line
						| baof_eligibility
						| ccategory2product_copy
						| ccategory_copy
						| country
						| cust_address_match_key_deprecated
						| cust_address_normalized
						| cust_address_normalize_error
						| display_category2ccategory_copy
						| estimated_product_cost
						| forecast_inventory
						| forecast_order_history
						| forecast_product
						| forecast_purchasing
						| inventory_summary
						| log_retire
						| order2eligibility
						| order_item
						| order_status
						| order_view
						| price_group_manufacturer_pricing
						| price_group_pricing
						| product_demand
						| product_price
						| product_price2
						| ranktable
						| state
						| state_paypal
						| store_manufacturer_pricing
						| vendor_min_cost
					)$
				/x', // x modififer => white space is ignored (so we can format for readability)
			),
		),
		'vendor_import' => array(
		       'acceptable_join_databases' => array('content3', 'user', 'superstore'),
		),
		'event' => array(
			'acceptable_join_databases' => array('user', 'superstore'),
		)
	),
	
);

?>
