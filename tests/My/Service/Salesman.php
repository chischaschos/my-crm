<?php

include '../application/global.php';
$application = new Zend_Application(
                APPLICATION_ENV,
                APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap();

//My_Service_Salesman::assingCustomers(array());
print_r(My_Service_Salesman::getNames());


