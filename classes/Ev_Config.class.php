<?php
class Ev_Config
{
	protected static $config = array();
	
	public static function initConfig($userConfig, $defaultConfig = null)
	{
		if (!is_null($defaultConfig))
		{
			self::$config = As_Array::merge($userConfig, $defaultConfig);
		}
		else
		{
			self::$config = $userConfig;
		}
		
		self::activateConfig();
	}
	
	public static function getConfig()
	{
		return self::$config;
	}
	
	public static function activateConfig()
	{
		// Spawn environment
		if (self::$config['environment'] == 'dev')
		{
			define('DEV', true);
		}
		else
		{
			define('DEV', false);
		}
		
		// Setup CoughPHP
		CoughDatabaseFactory::addConfig(self::$config['mysql']);
		
		// Setup Sphinx
		self::$config['sphinx']['mode'] = (int) self::$config['sphinx']['mode'];
		self::$config['sphinx']['port'] = (int) self::$config['sphinx']['port'];
		Ev_Search::setConfig(self::$config['sphinx']);
	}
}
