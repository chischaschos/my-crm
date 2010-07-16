<?php

include '../application/global.php';
$application = new Zend_Application(
                APPLICATION_ENV,
                APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap();

//$contact = My_Service_Contact::createByEmail('a@blabla.com');
$customers = My_Service_Customer::getActiveByCriteria();
var_dump($customers->toArray(true));

