<?php

/**
 * Handles all file uploads
 */
class UploadController extends Zend_Controller_Action {
    const UPLOAD_FILE_ID = 'file';

    protected $logger;

    public function init() {

        $this->_helper->layout->disableLayout();
        $this->logger = Zend_Registry::get('logger');
    }

    /**
     * Displays the mass upload menu
     */
    public function indexAction() {

        $this->view->form = new My_Form_Upload();
    }

    /**
     * Handles the mass upload process
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
                    'updateMethodName' => 'massUpload.progressUpdateHandler',
                    'finishMethodName' => 'massUpload.progressFinishHandler'
                ));

        /*
         * Third we assign the progress adapter to our upload, requires some 
         * missed extensions
         */
        //Zend_File_Transfer_Adapter_Http::getProgress($progressAdapter);

        /*
         * Fourth we assing the progress bar to the adapter
         */
        $progressBar = new Zend_ProgressBar($progressAdapter, 0, 100);

        /*
         * And that's it lets start updating
         */
        $progressBar->update(25, 'Recibiendo archivo');
        $upload->addValidator('Extension', false, array('csv'))
                ->addValidator('Count', 1, 1);
        $progressBar->update(50, 'Validando estructura del archivo');
        $fileName = $upload->getFileName($this->UPLOAD_FILE_ID);
        $customersData = null;

        if (!$upload->isUploaded($this->UPLOAD_FILE_ID) ||
                !$upload->isValid($this->UPLOAD_FILE_ID) ||
                !$upload->receive($this->UPLOAD_FILE_ID)) {

            $this->view->error = $upload->getMessages();
            $progressBar->update(75, 'Ocurrio un error interno');
        } else {

            $progressBar->update(75, 'Validando datos');
            $customersData =
                    My_Service_Customer::getDataFromCSV($fileName);
            $this->logger->info('Customers added');

            $progressBar->update(85, 'Asignando vendedores');

            if (count($customersData['valid']) > 0) {
                My_Service_Salesman::assingCustomers($customersData['valid']);
            }

            $this->logger->info('Got customersData');

            $uploadSession = new Zend_Session_Namespace('upload');
            $uploadSession->result = $customersData;
            $uploadSession->fileName = $fileName;

            $progressBar->update(95, 'Preparando resultados');
            $progressBar->update(100);
        }

        $body = 'El archivo  ' . basename($fileName);

        if ($customersData) {

            $body .= ' fue recibido y se encontraron ' .
                    count($customersData['valid']) . ' datos validos, ' .
                    count($customersData['invalid']) . ' datos invalidos y ' .
                    count($customersData['duplicated']) . ' datos duplicados';
        } else {

            $body .= ' no fue recibido debido a que estaba dañado u ocurrio ' .
                    'un error interno';
        }

        My_Service_Message::create(array(
                    'user' => Zend_Auth::getInstance()->getIdentity(),
                    'subject' => 'Carga en masa terminada',
                    'body' => $body
                ));

        $progressBar->finish();
    }

    /**
     * Returns mass upload results
     */
    public function resultAction() {

        $uploadSession = new Zend_Session_Namespace('upload');
        $this->view->result = $uploadSession->result;
        $this->view->fileName = $uploadSession->fileName;
    }

}

