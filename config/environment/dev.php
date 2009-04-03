<?php
define('DEV', true);
// Setup database config
CoughDatabaseFactory::addConfig(array(
	'adapter' => 'as',
	'driver' => 'mysql',
	'host' => '127.0.0.1',
	'user' => 'evently',
	'pass' => '3v3ntlyr0cks2!',
	'aliases' => array('evently'),
));
?>