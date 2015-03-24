<?php

// Define path to application directory
defined('APPLICATION_PATH')
        || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
        || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));


set_include_path(get_include_path().PATH_SEPARATOR.dirname(__FILE__).'/../library');

require 'Zend/Loader/Autoloader.php';
Zend_Loader_Autoloader::getInstance()->registerNamespace('Zend_');
Zend_Loader_Autoloader::getInstance()->registerNamespace('SecappDemo_');
Zend_Loader_Autoloader::getInstance()->registerNamespace('De_');

// Create application, bootstrap, and run
$application = new SecappDemo_Application(
                APPLICATION_ENV,
                APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap()
        ->run();