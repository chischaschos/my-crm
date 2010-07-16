<?php
class Doctrine_EventListener_QueryExecution extends Doctrine_EventListener {

    public function preStmtExecute(Doctrine_Event $event) {

        $logger = Zend_Registry::get('logger');
        $logger->info(__CLASS__ . ' ' . $event->getQuery());
        $logger->info(__CLASS__ . ' ' . print_r($event->getParams(), true));
    
    }

}
