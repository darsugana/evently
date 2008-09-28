<?php
/**
 * Academic Superstore Cough Generator Config
 *
 * @author Anthony Bush
 * @version $Id: cough_generator.inc.php,v 1.17 2008/07/09 22:24:19 richard Exp $
 **/


$generated = dirname(dirname(dirname(__FILE__))) . '/models/';

$config = array(
	
	'phpDoc' => array(
		'author' => 'CoughGenerator',
		'package' => 'events',
		'copyright' => 'events',
	),
	
	'paths' => array(
		'generated_classes' => $generated,// . 'generated_classes/',
		'starter_classes' => $generated,// . 'starter_classes/',
		'file_suffix' => '.class.php',
	),
	
	// 'load_sql_inner_joins' => 'enabled',
	
	'class_names' => array(
		// You can add prefixes to class names that are generated
		'prefix' => '',
		// Additionally, you can strip table prefixes from the generated class names (note that you might run into naming conflicts though.)
		//'strip_table_name_prefixes' => array('cust_', 'wfl_', 'baof_', 'inv_'),
		// Suffixes...
		'base_object_suffix' => '_Generated',
		'base_collection_suffix' => '_Collection_Generated',
		'starter_object_suffix' => '',
		'starter_collection_suffix' => '_Collection',
		'object_extension_class_name' => 'AppCoughObject',
		'collection_extension_class_name' => 'AppCoughCollection',
	),
	
	'field_settings' => array(
		'delete_flag_column' => 'is_deleted',
		'delete_flag_value' => '1',
	),
	
	'databases' => array(
		'events' => array(
			'class_names' => array(
				'prefix' => '',
			),
			'paths' => array(
				'generated_classes' => $generated . 'generated/',
				'starter_classes' => $generated . 'concrete/',
			),
			'generate_has_many_methods' => array(),
		),
	)
);

?>