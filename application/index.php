<?php

require dirname(__FILE__) . '/global.php';
/** Zend_Application */
require_once '../library/Zend/Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
                APPLICATION_ENV,
                APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap()
        ->run();
