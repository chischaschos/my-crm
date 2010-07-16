<?php

class My_Controller_Plugin_Auth extends Zend_Controller_Plugin_abstract {

    protected $logger;

    public function __construct() {

        $this->logger = Zend_Registry::get('logger');
    }

    public function preDispatch(Zend_Controller_Request_Abstract $request) {

        $controllerName = $request->getControllerName();
        $actionName = $request->getActionName();

        $this->logger->info('Requested controller_action: ' . $controllerName . '_' .
                $actionName);

        $acl = My_Acl::getInstance();
        $auth = Zend_Auth::getInstance();
        $role = $auth->getIdentity()->role;
        $this->logger->info(__CLASS__ . ' role: ' . $role);


        if (!$acl->isAllowed($role, $controllerName . '_' . $actionName)) {

            $this->logger->info(__CLASS__ . ' Acl result: Not allowed');

            if ($auth->hasIdentity()) {

                $dispatcher = Zend_Controller_Front::getInstance()
                                ->getDispatcher();
                $request->setControllerName('index');
                $request->setActionName('index');
                $request->setDispatched(false);
            } else {

                $request->setParam('prevController', $controllerName);
                $request->setParam('prevAction', $actionName);
                $request->setControllerName('auth');
                $request->setActionName('auth');
                $request->setDispatched(false);
            }
        } else {

            $this->logger->info(__CLASS__ . ' Acl result: Allowed');
        }
    }

}
