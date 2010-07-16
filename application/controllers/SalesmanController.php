<?php

/**
 * Handles all file uploads
 */
class SalesmanController extends Zend_Controller_Action {

    protected $logger;

    public function init() {

        $this->_helper->layout->disableLayout();
        $this->logger = Zend_Registry::get('logger');
    }

    public function searchhomeAction() {

        $this->view->searchForm = new My_Form_Salesman_Search();
    }

    public function addhomeAction() {

        $this->view->form = new My_Form_Salesman_Add();
    }

    /**
     * Adds new salesmans
     */
    public function addAction() {

        $this->logger->info('add salesman');
        $this->_helper->viewRenderer->setNoRender(true);
        $form = new My_Form_Salesman_Add();
        $result = new My_Bean_Result();

        if ($form->isValid($_POST)) {

            $salesman = new Salesman();
            $address = new Address();

            $salesmanValues = $form->getSubForm('salesman')->getValues();
            $addressValues = $form->getSubForm('address')->getValues();

            $this->logger->info(print_r($salesmanValues['salesman'], true));
            $this->logger->info(print_r($addressValues['address'], true));

            $salesman->merge($salesmanValues['salesman']);
            $address->merge($addressValues['address']);

            $salesman->Address = $address;
            $salesman->save();

            $result->status = My_Constant_Status::OK;
        } else {

            $result->status = My_Constant_Status::ERROR;
            $this->logger->err(My_Constant_Error::E1000);
            $this->logger->err(print_r($form->getMessages(), true));
        }

        echo json_encode($result->toArray());
    }

    /**
     * Looks for all active salesmans
     */
    public function searchAction() {

        $this->logger->info('Retrieving salesmans');
        $searchForm = new My_Form_Salesman_Search();

        if ($searchForm->isValid($_POST)) {

            $this->view->salesmans =
                    My_Service_Salesman::getActiveByCriteria($searchForm->getValues());
        } else {


            $this->logger->err(My_Constant_Error::E1000);
            $this->view->salesmans =
                    My_Service_Salesman::getActiveByCriteria();
        }
    }

    public function viewAction() {

        $salesmanId = $this->_getParam('salesmanId');
        $this->logger->info('View salesmanId: ' . $salesmanId);
        $validator = new Zend_Validate_Regex('/^\d+$/');

        if (!$validator->isValid($salesmanId)) {

            $this->logger->info(My_Constant_Error::E1000);
            $this->_redirect('error/json');
        }

        $this->view->form = new My_Form_Salesman_View();
        $salesman = Doctrine::getTable('Salesman')->find($salesmanId);
        $this->view->form->populate($salesman->toArray(true));
    }

    /**
     * Returns a json list of ids and full names
     *
     */
    public function namesAction() {

        $this->_helper->viewRenderer->setNoRender(true);
        echo json_encode(My_Service_Salesman::getNames());
    }

}

