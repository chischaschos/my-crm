<?php

// Define path to application directory
defined('APPLICATION_PATH')
        || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
        || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(dirname(__FILE__) . '/../library/Zend'
        . PATH_SEPARATOR . dirname(__FILE__) . '/../library/Doctrine'
        . PATH_SEPARATOR . dirname(__FILE__) . '/library'
        . PATH_SEPARATOR . dirname(__FILE__) . '/models'
        . PATH_SEPARATOR . dirname(__FILE__) . '/models/generated'
        . PATH_SEPARATOR . get_include_path());
require_once 'Zend/Loader/Autoloader.php';
Zend_Loader_Autoloader::getInstance()->registerNameSpace('Doctrine_')->setFallbackAutoloader(true);
Doctrine_Manager::connection("mysql://mycrm:mycrm@localhost/mycrm");

/*
 * Configure Doctrine
 */
Zend_Registry::set('doctrine_config', array(
            'data_fixtures_path' => dirname(__FILE__) . '/doctrine/data/fixtures',
            'models_path' => dirname(__FILE__) . '/models',
            'migrations_path' => dirname(__FILE__) . '/doctrine/migrations',
            'sql_path' => dirname(__FILE__) . '/doctrine/data/sql',
            'yaml_schema_path' => dirname(__FILE__) . '/doctrine/schema'
        ));
