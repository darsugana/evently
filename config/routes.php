<?php

// Format of regex => parseInfo
$regexRoutes = array(
	
	// Map nothing to the home page.
	'#^$#' => array(
		'controller' => 'home',
		'action' => 'index',
	),
	
	// Map events view page
	'#^event/([^/]+)/?$#' => array(
		'controller' => 'event',
		'action' => 'view',
		'additional_params' => 1,
	),
				
	// Map controler/action/params
	'#^([^/]+)/([^/]+)/?(.*)$#' => array(
		'controller' => 1,
		'action' => 2,
		'additional_params' => 3,
	),
	
	// Map controllers to a default action (not needed if you use the
	// Lvc_Config static setters for default controller name, action
	// name, and action params.)
	'#^([^/]+)/?$#' => array(
		'controller' => 1,
		'action' => 'index',
	),
	
);

?>