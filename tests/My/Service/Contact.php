<?php

include '../application/global.php';
$application = new Zend_Application(
                APPLICATION_ENV,
                APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap();

//$contact = My_Service_Contact::createByEmail('a@blabla.com');
$contact = My_Service_Contact::getByTelephone('4759832123');
var_dump($contact);
echo PHP_EOL . (isset($contact->id)) . PHP_EOL;



