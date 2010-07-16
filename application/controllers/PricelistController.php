<?php

/**
 * Handles all file uploads
 */
class PricelistController extends Zend_Controller_Action {
    const UPLOAD_FILE_ID = 'file';

    protected $logger;

    public function init() {

        $this->_helper->layout->disableLayout();
        $this->logger = Zend_Registry::get('logger');
    }

    /**
     * Displays the price list menu
     */
    public function homeAction() {

        $form = new My_Form_Upload();
        $form->setAttrib('action', $this->view->url(array(
                    'controller' => 'pricelist',
                    'action' => 'upload'
                )));

        $this->view->form = $form;
        $this->view->pricelistForm = new My_Form_Pricelist();
    }

    /**
     * Handles the price list upload process
     */
    public function uploadAction() {

        $this->_helper->viewRenderer->setNoRender(true);
        $this->logger->info(__CLASS__ . ' ' . __FUNCTION__);
        /*
         * First we create the upload
         */
        $upload = new Zend_File_Transfer_Adapter_Http();

        /*
         * Second we create the progress adapter
         */
        $progressAdapter =
                new Zend_ProgressBar_Adapter_JsPush(array(
                    'updateMethodName' => 'pricelist.progressUpdateHandler',
                    'finishMethodName' => 'pricelist.progressFinishHandler'
                ));

        /*
         * Fourth we assing the progress bar to the adapter
         */
        $progressBar = new Zend_ProgressBar($progressAdapter, 0, 100);

        /*
         * And that's it lets start updating
         */
        $progressBar->update(25, 'Recibiendo archivo');
        //        $upload->addValidator('Extension', false, array('csv'))
        //            ->addValidator('Count', 1, 1);
        $progressBar->update(50, 'Validando estructura del archivo');
        $fileName = $upload->getFileName($this->UPLOAD_FILE_ID);

        if (!$upload->isUploaded($this->UPLOAD_FILE_ID) ||
                !$upload->isValid($this->UPLOAD_FILE_ID) ||
                !$upload->receive($this->UPLOAD_FILE_ID)) {

            $this->logger->err(My_Constant_Error::E1001);
            $this->logger->err(print_r($upload->getMessages(), true));
            $progressBar->update(90, My_Constant_Status::ERROR);
        } else {


            $pricelist = new Pricelist();
            $pricelist->name = basename($upload->getFileName($this->UPLOAD_FILE_ID));
            $pricelist->contenttype = $upload->getMimeType($this->UPLOAD_FILE_ID);
            $pricelist->content = file_get_contents($upload->getFileName($this->UPLOAD_FILE_ID));
            $pricelist->size = $upload->getFileSize($this->UPLOAD_FILE_ID);
            $pricelist->save();

            $progressBar->update(90, My_Constant_Status::OK);
        }



        $progressBar->finish();
    }

    /**
     * View all existing price lists
     */
    public function viewallAction() {

        $this->view->pricelists = My_Service_Pricelist::getAll();
    }

    public function deleteAction() {

        $this->_helper->viewRenderer->setNoRender(true);

        $pricelistId = $this->_getParam('id');
        $this->logger->info('Delete pricelist id: ' . $pricelistId);
        $validator = new Zend_Validate_Int();

        if (!$validator->isValid($pricelistId)) {

            $this->logger->err(My_Constant_Error::E1000);
            $this->logger->err(print_r($validator->getMessages(), true));
            $this->_redirect('error/json');
        } else {

            $deletedRows = My_Service_Pricelist::deleteById($pricelistId);
            $result = new My_Bean_Result();
            $result->message = $deletedRows;
            $result->status = My_Constant_Status::OK;

            echo json_encode($result->toArray());
        }
    }

    public function viewAction() {

        $this->_helper->viewRenderer->setNoRender(true);

        $pricelistId = $this->_getParam('id');
        $this->logger->info('View pricelist id: ' . $pricelistId);
        $validator = new Zend_Validate_Int();

        if (!$validator->isValid($pricelistId)) {

            $this->logger->err(My_Constant_Error::E1000);
            $this->logger->err(print_r($validator->getMessages(), true));
            $this->_redirect('error');
        } else {

            My_Service_Pricelist::getRawById($pricelistId);
        }
    }

    public function editAction() {

        $this->_helper->viewRenderer->setNoRender(true);
        $form = new My_Form_Pricelist();
        $result = new My_Bean_Result();

        if ($form->isValid($_POST) &&
                My_Service_Pricelist::update($form->getValues())) {

            $result->status = My_Constant_Status::OK;
            $result->message = json_encode($form->getValues());
        } else {

            $this->logger->err(My_Constant_Error::E1000);
            $this->logger->err(print_r($form->getMessages(), true));
            $result->status = My_Constant_Status::ERROR;
            $result->message = 'Un error ocurrio intenta mas tarde, gracias';
        }

        echo json_encode($result->toArray());
    }

}

