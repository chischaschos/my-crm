<?php

include '../application/global.php';
$application = new Zend_Application(
                APPLICATION_ENV,
                APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap();

My_Service_Message::create(array(
            'user' => Doctrine::getTable('User')->findOneByRole('GUE'),
            'subject' => 'test subject',
            'message' => 'test message'
        ));
