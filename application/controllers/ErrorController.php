<?php

class ErrorController extends Zend_Controller_Action {

    protected $logger;

    public function init() {

        $this->_helper->layout->disableLayout();
        $this->logger = Zend_Registry::get('logger');
    }

    public function errorAction() {

        $errors = $this->_getParam('error_handler');

        switch ($errors->type) {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:

                // 404 error -- controller or action not found
                $this->getResponse()->setHttpResponseCode(404);
                $this->view->message = 'Page not found';
                break;
            default:
                // application error 
                $this->getResponse()->setHttpResponseCode(500);
                $this->view->message = 'Application error';
                break;
        }

        $this->view->exception = $errors->exception;
        $this->logger->err($errors->exception);
        $this->view->request = $errors->request;
        $this->logger->err($errors->request);
    }

    public function jsonAction() {

        $this->_helper->viewRenderer->setNoRender(true);
        $errors = $this->_getParam('error_handler');
        $this->logger->err('Exception: ' . $errors->exception);
        $this->logger->err('Request: ' . $errors->request);

        $result = new My_Bean_Result();
        $result->message = 'Application error';
        $result->status = My_Constant_Status::ERROR;

        echo json_encode($result->toArray());
    }

}

