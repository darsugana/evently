<?php
// Grab the current timestamp
define('CURRENT_TIMESTAMP', time());

// Derived Constants
// (NOTE that these are not needed by LightVC, but are usually useful in the app layer.)
define('APP_PATH', dirname(dirname(__FILE__)) . '/');
define('WWW_BASE_PATH', str_replace('index.php', '', $_SERVER['SCRIPT_NAME']));
define('WWW_CSS_PATH', WWW_BASE_PATH . 'css/');
define('WWW_JS_PATH', WWW_BASE_PATH . 'js/');
define('WWW_IMAGE_PATH', WWW_BASE_PATH . 'images/');

// Include messaging helper
include(APP_PATH . 'classes/As_Message.class.php');

// Start session
session_start();
As_Message::setSessionStarted(true);

// Include Debug helpers
include(APP_PATH . 'classes/Debug.class.php');

// Include CoughPHP
include(APP_PATH . 'modules/coughphp/load.inc.php');
include(APP_PATH . 'classes/AppCoughObject.class.php');
include(APP_PATH . 'classes/AppCoughCollection.class.php');

// Include database adapters
include(APP_PATH . 'modules/coughphp/as_database/As_Database.class.php');
include(APP_PATH . 'modules/coughphp/as_database/As_DatabaseResult.class.php');
include(APP_PATH . 'modules/coughphp/dal/as/CoughAsDatabase.class.php');
include(APP_PATH . 'modules/coughphp/dal/as/CoughAsDatabaseResult.class.php');

// Include env specific confs
include('environment.php');

// Include SimplePie
include(APP_PATH . 'modules/simplepie/simplepie.inc');

// Configure autoloader
include(APP_PATH . 'classes/Autoloader.class.php');
Autoloader::setCacheFilePath(APP_PATH . 'tmp/class_path_cache.txt');
Autoloader::excludeFolderNamesMatchingRegex('/^CVS|\..*$/');
Autoloader::setClassPaths(array(
	APP_PATH . 'classes/',
	APP_PATH . 'models/',
));
spl_autoload_register(array('Autoloader', 'loadClass'));

// Include and configure the LighVC framework
include(APP_PATH . 'modules/lightvc/lightvc.php');
Lvc_Config::addControllerPath(APP_PATH . 'controllers/');
Lvc_Config::addControllerViewPath(APP_PATH . 'views/');
Lvc_Config::addLayoutViewPath(APP_PATH . 'views/layouts/');
Lvc_Config::addElementViewPath(APP_PATH . 'views/elements/');
Lvc_Config::setViewClassName('AppView');

// Lvc doesn't autoload the AppController, so we have to do it: (this also means we can put it anywhere)
include(APP_PATH . 'classes/AppController.class.php');
include(APP_PATH . 'classes/AppView.class.php');

// Load Routes
include(dirname(__FILE__) . '/routes.php');
?>