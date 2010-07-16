<?php

class CommonController extends Zend_Controller_Action {

    /**
     * Displays menu per role
     */
    public function menubarAction() {

        $this->_helper->layout->disableLayout();
        $this->view->menu = $this->getMenu(
                        Zend_Auth::getInstance()->getIdentity()->role
        );
    }

    /**
     * Displays the header bar wich includes menu and session information
     */
    public function headerbarAction() {

        $auth = Zend_Auth::getInstance();

        $this->view->userName = $auth->getIdentity()->name;
        $this->view->userType = strtolower($auth->getIdentity()->role);
        $this->view->environment = strtolower(APPLICATION_ENV);
        $this->view->version = '0.4';
    }

    /**
     * Returns an array with menu configurations per role
     *
     * @param User::ADMIN|User::CUSTOMER|User::GUEST|User::SALESMAN
     * @return array
     */
    private function getMenu($role) {

        /*
         * Call type is by default html
         */
        $menu = array(
            User::GUEST => array(
                'Cuentas' => array(
                    'register' => array(
                        'url' => $this->view->url(array(
                            'action' => 'home',
                            'controller' => 'register')),
                        'value' => 'Registrarse'),
                    'login' => array(
                        'url' => $this->view->url(array(
                            'action' => 'login',
                            'controller' => 'auth')),
                        'value' => 'Ingresar')
                )
            ),
            User::ADMIN => array(
                'Cliente' => array(
                    'massUpload' => array(
                        'url' => $this->view->url(array(
                            'action' => 'index',
                            'controller' => 'upload')),
                        'value' => 'Carga en masa'
                    ),
                    'clientSearchHome' => array(
                        'url' => $this->view->url(array(
                            'action' => 'searchhome',
                            'controller' => 'client')),
                        'value' => 'Busqueda'
                    ),
                    'clientAddHome' => array(
                        'url' => $this->view->url(array(
                            'action' => 'addhome',
                            'controller' => 'client')),
                        'value' => 'Agregar'
                    )
                ),
                'Vendedor' => array(
                    'salesmanAssignHome' => array(
                        'url' => $this->view->url(array(
                            'action' => 'assignhome',
                            'controller' => 'salesman')),
                        'value' => 'Asignacion de cliente'
                    ),
                    'salesmanSearchHome' => array(
                        'url' => $this->view->url(array(
                            'action' => 'searchhome',
                            'controller' => 'salesman')),
                        'value' => 'Busqueda'
                    ),
                    'salesmanAddHome' => array(
                        'url' => $this->view->url(array(
                            'action' => 'addhome',
                            'controller' => 'salesman')),
                        'value' => 'Agregar'
                    )
                ),
                'Lista de precios' => array(
                    'pricelist' => array(
                        'url' => $this->view->url(array(
                            'action' => 'home',
                            'controller' => 'pricelist')),
                        'value' => 'Administracion'
                    ),
                ),
                'Reportes' => array(
                    'reporta' => array(
                        'url' => $this->view->url(array(
                            'action' => 'reporta',
                            'controller' => 'report')),
                        'value' => 'Reporte A'
                    ),
                ),
                'Alertas' => array(
                    'id' => 'alertsMenu',
                    'alerts' => array(
                        'url' => $this->view->url(array(
                            'action' => 'index',
                            'controller' => 'message')),
                        'value' => 'Mis alertas'
                    ),
                ),
                'Catalogos' => array(
                    'catalogs' => array(
                        'url' => $this->view->url(array(
                            'action' => 'home',
                            'controller' => 'catalogs')),
                        'value' => 'Mis catalogos'
                    ),
                ),
                'Sesion' => array(
                    'logout' => array(
                        'url' => $this->view->url(array(
                            'action' => 'logout',
                            'controller' => 'auth')),
                        'value' => 'Cerrar',
                        'dataType' => 'json'
                    )
                )
            )
        );


        return $menu[$role];
    }

}

