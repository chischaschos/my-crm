<?php

include '../application/global.php';
$application = new Zend_Application(
                APPLICATION_ENV,
                APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap();

$result = new My_Bean_Result();
$result->caller = 'c10';
$result->status = 's10';
$result->message = 'm10';

print_r($result->toArray());

echo $result;

