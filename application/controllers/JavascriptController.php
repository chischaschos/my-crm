<?php

class JavascriptController extends Zend_Controller_Action {

    public function init() {

        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
    }

    /**
     * This action returns a javascript declaration showing how javascript
     * service calling and handling should be achieved
     */
    public function optionsAction() {

        $servicesList = array(
            'massUploadResult' => array(
                'url' => $this->view->url(array(
                    'controller' => 'upload',
                    'action' => 'result'
                ))
            ),
            'clientSearch' => array(
                'url' => $this->view->url(array(
                    'controller' => 'client',
                    'action' => 'search'
                ))
            ),
            'menu' => array(
                'url' => $this->view->url(array(
                    'controller' => 'common',
                    'action' => 'menubar'
                ))
            ),
            'salesman' => array(
                'view' => array(
                    'url' => $this->view->url(array(
                        'controller' => 'salesman',
                        'action' => 'view'))
                ),
                'names' => array(
                    'url' => $this->view->url(array(
                        'controller' => 'salesman',
                        'action' => 'names'))
                ),
            ),
            'salesmanSearch' => array(
                'url' => $this->view->url(array(
                    'controller' => 'salesman',
                    'action' => 'search'
                ))
            ),
            'client' => array(
                'view' => array(
                    'url' => $this->view->url(array(
                        'controller' => 'client',
                        'action' => 'view'
                    ))
                )
            ),
            'alert' => array(
                'news' => array(
                    'url' => $this->view->url(array(
                        'controller' => 'alert',
                        'action' => 'news'
                    ))
                )
            ),
            'pricelist' => array(
                'viewall' => array(
                    'url' => $this->view->url(array(
                        'controller' => 'pricelist',
                        'action' => 'viewall'))
                ),
                'view' => array(
                    'url' => $this->view->url(array(
                        'controller' => 'pricelist',
                        'action' => 'view'))
                ),
                'delete' => array(
                    'url' => $this->view->url(array(
                        'controller' => 'pricelist',
                        'action' => 'delete'))
                ),
                'edit' => array(
                    'url' => $this->view->url(array(
                        'controller' => 'pricelist',
                        'action' => 'edit'))
                )
            ),
            'catalogs' => array(
                'view' => array(
                    'url' => $this->view->url(array(
                        'controller' => 'catalogs',
                        'action' => 'view'))
                ),
                'add' => array(
                    'url' => $this->view->url(array(
                        'controller' => 'catalogs',
                        'action' => 'add'))
                ),
                'edit' => array(
                    'url' => $this->view->url(array(
                        'controller' => 'catalogs',
                        'action' => 'edit'))
                ),
                'delete' => array(
                    'url' => $this->view->url(array(
                        'controller' => 'catalogs',
                        'action' => 'delete'))
                ),
            )
        );

        echo "var SERVICE = " . json_encode($servicesList) . ";";
        echo "var BASE_URL = '" . $this->view->baseUrl() . "';";
    }

}

