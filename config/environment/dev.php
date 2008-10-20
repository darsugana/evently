<?php
// Setup database config
CoughDatabaseFactory::addConfig(array(
	'adapter' => 'as',
	'driver' => 'mysql',
	'host' => '127.0.0.1',
	'user' => 'root',
	'pass' => '',
	'aliases' => array('evently'),
));
?>