<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
// Define path to application directory
defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__FILE__)));

// Define application environment
defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH),
    get_include_path()
)));

// Define path to data directory§
defined('APPLICATION_DATA') || define('APPLICATION_DATA', realpath(dirname(__FILE__) . '/../../data/logs'));

function restautoload($path) {
    if (file_exists(str_replace('_', '/', $path) . '.php')) {
        //rest include
        require_once(str_replace('_', '/', $path) . '.php');
        return true;
    }

    throw new Exception("Geen class " . $path . " gevonden");
}

spl_autoload_register('restautoload');
$rest = new Rest();
$rest->process();
ob_end_flush();
