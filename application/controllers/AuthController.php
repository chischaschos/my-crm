<?php

class AuthController extends Zend_Controller_Action {

    protected $logger;

    public function init() {

        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $this->logger = Zend_Registry::get('logger');
    }

    /**
     * By default if request type is not post, then we use empty password and 
     * username which results in setting User::GUEST indentity.
     */
    public function authAction() {

        $username = '';
        $password = '';

        $loginForm = new My_Form_Auth_Login();

        if ($this->_request->isPost() && $loginForm->isValid($_POST)) {

            $formValues = $loginForm->getValues();
            $username = $formValues['username'];
            $password = $formValues['password'];
        }

        $authAdapter = new My_Auth_Adapter($username, $password);
        $auth = Zend_Auth::getInstance();
        $authResult = $auth->authenticate($authAdapter);

        $prevController = $this->getRequest()->getUserParam('prevController');
        $prevAction = $this->getRequest()->getUserParam('prevAction');

        $this->logger->info('PrevController: ' . $prevController);
        $this->logger->info('PrevAction: ' . $prevAction);

        $redirectTo = 'index';

        if (null !== $prevController) {

            $redirectTo = $prevController .
                    ((null !== $prevAction) ? '/' . $prevAction : '');
            $this->_redirect($redirectTo);
        } else {

            $result = new My_Bean_Result();
            $result->status = 'ok';
            $result->message = 'Haz iniciado sesion como ' .
                    $auth->getIdentity()->role;
            echo json_encode($result->toArray());
        }
    }

    public function loginAction() {

        $this->_helper->viewRenderer->setNoRender(false);
        $this->view->form = new My_Form_Auth_Login();
    }

    public function logoutAction() {

        Zend_Auth::getInstance()->clearIdentity();
        Zend_Session::destroy();

        $result = new My_Bean_Result();
        $result->status = true;
        $result->caller = 'logout';
        $result->message = 'Tu sesion ha sido cerrada';

        echo json_encode($result->toArray());
    }

}

