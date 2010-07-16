<?php

class AlertController extends Zend_Controller_Action {

    protected $logger;

    public function init() {

        $this->logger = Zend_Registry::get('logger');
        $this->_helper->layout->disableLayout();
    }

    public function newsAction() {

        if ($this->getRequest()->isXmlHttpRequest()) {

            $this->_helper->viewRenderer->setNoRender(true);
            $user = Zend_Auth::getInstance()->getIdentity();
            $alerts = My_Service_Message::getLatestByUser($user->id, false);
            echo json_encode($alerts->toArray());
        } else {

            $this->view->alerts = My_Service_Message::getLatestByUser($user->id, true);
        }
    }

}

