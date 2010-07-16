<?php

/**
 * This controller handles all catalogs CRUDs
 */
class CatalogsController extends Zend_Controller_Action {

    protected $logger;

    public function init() {

        $this->_helper->layout->disableLayout();
        $this->logger = Zend_Registry::get('logger');
    }

    /**
     * Displays the catalogs home menu
     */
    public function homeAction() {

        $this->view->pricelistCategoryForm = new My_Form_Catalogs_PricelistCategory();
    }

    public function viewAction() {

        $catalog = $this->_getParam('catalog');
        $view = 'view';

        switch ($catalog) {

            case 'pricelistCategory': {

                    $this->view->id = 'pricelistCategory';
                    $this->view->title = 'Categorias de listas de precios';
                    $this->view->catalogs = My_Service_Catalogs::getPricelistCategory();
                    $view = 'pricelistcategory';
                    break;
                }

            default: {
                    
                }
        }

        $this->render($view);
    }

    public function addAction() {

        $this->_helper->viewRenderer->setNoRender(true);
        $catalog = $this->_getParam('catalog');
        $result = new My_Bean_Result();

        switch ($catalog) {

            case 'pricelistCategory': {

                    $form = new My_Form_Catalogs_PricelistCategory();

                    if ($form->isValid($_POST)) {

                        $exists = My_Service_Catalogs::existsPricelistCategory($form->getValues());

                        if (!$exists) {

                            $newPLC = My_Service_Catalogs::addPricelistCategory($form->getValues());
                            $result->status = My_Constant_Status::OK;
                            $result->message = $newPLC->id;
                        } else {

                            $result->status = My_Constant_Status::ERROR;
                            $result->message = 'La categoria ' .
                                    $form->getElement('category_name')->getValue() .
                                    ' no fue agregada pues ya existia';
                        }
                    } else {

                        $result->status = My_Constant_Status::ERROR;
                        $this->logger->err(My_Constant_Error::E1000);
                        $this->logger->err(print_r($form->getMessages(), true));
                    }

                    break;
                }

            default: {

                    $result->status = My_Constant_Status::ERROR;
                    $this->logger->err(My_Constant_Error::E1000);
                    $this->logger->err(print_r($form->getMessages(), true));
                }
        }

        echo json_encode($result->toArray());
    }

    public function deleteAction() {

        $this->_helper->viewRenderer->setNoRender(true);
        $catalog = $this->_getParam('catalog');
        $result = new My_Bean_Result();

        switch ($catalog) {

            case 'pricelistCategory': {

                    $pricelistCategoryId = $this->_getParam('id');
                    $intValidator = new Zend_Validate_Int();

                    if ($intValidator->isValid($pricelistCategoryId)) {


                        if (My_Service_Catalogs::removePricelistCategory($pricelistCategoryId)) {

                            $result->status = My_Constant_Status::OK;
                        } else {

                            $result->status = My_Constant_Status::ERROR;
                            $result->message = 'La categoria no puede ser removida ' .
                                    'pues contiene una lista de precios relacionada';
                        }
                    } else {

                        $result->status = My_Constant_Status::ERROR;
                        $this->logger->err(My_Constant_Error::E1000);
                        $this->logger->err(print_r($intValidator->getMessages(), true));
                    }

                    break;
                }

            default: {

                    $result->status = My_Constant_Status::ERROR;
                    $this->logger->err(My_Constant_Error::E1000);
                    $this->logger->err(print_r($form->getMessages(), true));
                }
        }

        echo json_encode($result->toArray());
    }

}

