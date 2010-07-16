<?php

/**
 * Handles all file uploads
 */
class ClientController extends Zend_Controller_Action {

    protected $logger;

    public function init() {

        $this->_helper->layout->disableLayout();
        $this->logger = Zend_Registry::get('logger');
    }

    /**
     * Shows the search form and basic search results
     */
    public function searchhomeAction() {

        $this->view->searchForm = new My_Form_Client_Search();
    }

    public function addhomeAction() {

        $this->view->form = new My_Form_Client_Add();
    }

    public function addAction() {

        $this->logger->info('add customer');
        $this->_helper->viewRenderer->setNoRender(true);
        $form = new My_Form_Client_Add();
        $result = new My_Bean_Result();

        if ($form->isValid($_POST)) {

            $customer = new Customer();
            $contact = new Contact();
            $address = new Address();

            $clientValues = $form->getSubForm('client')->getValues();
            $contactValues = $form->getSubForm('contact')->getValues();
            $addressValues = $form->getSubForm('address')->getValues();

            $this->logger->info(print_r($clientValues['client'], true));
            $this->logger->info(print_r($contactValues['contact'], true));
            $this->logger->info(print_r($addressValues['address'], true));

            $customer->merge($clientValues['client']);
            $contact->merge($contactValues['contact']);
            $address->merge($addressValues['address']);

            $customer->Contact = $contact;
            $customer->Contact->Address = $address;

            $salAssignType = $form->getSubForm('contact')
                            ->getElement('sal_assign_type')->getValue();
            $this->logger->info('Salesman assign type: ' . $salAssignType);

            if ('manu' == $salAssignType) {

                $salesmanId = $form->getSubForm('contact')
                                ->getElement('salesman')->getValue();
                $this->logger->info('Salesman id: ' . $salesmanId);
                $customer->Salesman = Doctrine::getTable('Salesman')
                                ->find($salesmanId);
            } else {

                $customer->Salesman = My_Service_Salesman::getNextAvailable();
            }

            $customer->save();
            $result->status = My_Constant_Status::OK;
        } else {

            $result->status = My_Constant_Status::ERROR;
            $this->logger->err(My_Constant_Error::E1000);
            $this->logger->err(print_r($form->getMessages(), true));
        }

        echo json_encode($result->toArray());
    }

    public function searchAction() {

        $this->logger->info('Retrieving customers');
        $searchForm = new My_Form_Client_Search();

        if ($searchForm->isValid($_POST)) {

            $this->view->contacts =
                    My_Service_Customer::getActiveByCriteria($searchForm->getValues());
        } else {

            $this->logger->err(My_Constant_Error::E1000);
            $this->view->contacts =
                    My_Service_Customer::getActiveByCriteria();
        }
    }

    public function viewAction() {

        $clientId = $this->_getParam('clientId');
        $this->logger->info('View clientId: ' . $clientId);
        $validator = new Zend_Validate_Regex('/^\d+$/');

        if (!$validator->isValid($clientId)) {

            $this->logger->error(My_Constant_Error::E1000);
            $this->logger->error(print_r($validator->getMessages(), true));
            $this->_redirect('error/json');
        }

        $form = new My_Form_Client_View();
        $client = Doctrine::getTable('Customer')->find($clientId);
        $form->getSubForm('client')->populate($client->toArray(true));
        $form->getSubForm('contact')->populate($client->Contact->toArray(true));
        $form->getSubForm('address')->populate($client->Contact->Address->toArray(true));

        $this->view->form = $form;
    }

}
