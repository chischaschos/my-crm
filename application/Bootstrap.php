<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    function _initViewHelpers() {

        $this->bootstrap('layout');
        $layout = $this->getResource('layout');
        $view = $layout->getView();
        $view->doctype('XHTML1_TRANSITIONAL');
        $view->headMeta()->appendHttpEquiv('Content-Type', 'text/html;charset=utf-8');
        $view->headTitle()->setSeparator(' - ');
        $view->headTitle('My CRM');
        $view->addHelperPath(APPLICATION_PATH . '/views/helpers/');
    }

    function _initLog() {

        $logger = new Zend_Log();
        $writer = new Zend_Log_Writer_Stream(APPLICATION_PATH . '/log/default.log');
        $logger->addWriter($writer);
        $logger->info('Logger initialized');
        Zend_Registry::set('logger', $logger);
    }

    function _initPlugins() {

        $front = Zend_Controller_Front::getInstance();
        $front->registerPlugin(new My_Controller_Plugin_Auth());
    }

    function _initDoctrine() {

        $conn = Doctrine_Manager::connection();
        $conn->setListener(new Doctrine_EventListener_QueryExecution());
    }

}

