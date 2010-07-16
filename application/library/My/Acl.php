<?php

class My_Acl extends Zend_Acl {

    protected static $instance = null;

    private function __construct() {

    }

    private function __clone() {

    }

    protected function initialize() {

        $this->add(new Zend_Acl_Resource('auth_login'))
                ->add(new Zend_Acl_Resource('auth_logout'))
                ->add(new Zend_Acl_Resource('auth_auth'))
                ->add(new Zend_Acl_Resource('error_error'))
                ->add(new Zend_Acl_Resource('error_json'))
                ->add(new Zend_Acl_Resource('javascript_options'))
                ->add(new Zend_Acl_Resource('index_index'))
                ->add(new Zend_Acl_Resource('upload_index'))
                ->add(new Zend_Acl_Resource('upload_upload'))
                ->add(new Zend_Acl_Resource('upload_result'))
                ->add(new Zend_Acl_Resource('salesman_searchhome'))
                ->add(new Zend_Acl_Resource('salesman_search'))
                ->add(new Zend_Acl_Resource('salesman_addhome'))
                ->add(new Zend_Acl_Resource('salesman_add'))
                ->add(new Zend_Acl_Resource('salesman_view'))
                ->add(new Zend_Acl_Resource('salesman_names'))
                ->add(new Zend_Acl_Resource('client_searchhome'))
                ->add(new Zend_Acl_Resource('client_search'))
                ->add(new Zend_Acl_Resource('client_addhome'))
                ->add(new Zend_Acl_Resource('client_add'))
                ->add(new Zend_Acl_Resource('client_view'))
                ->add(new Zend_Acl_Resource('common_menubar'))
                ->add(new Zend_Acl_Resource('alert_news'))
                ->add(new Zend_Acl_Resource('pricelist_home'))
                ->add(new Zend_Acl_Resource('pricelist_view'))
                ->add(new Zend_Acl_Resource('pricelist_viewall'))
                ->add(new Zend_Acl_Resource('pricelist_upload'))
                ->add(new Zend_Acl_Resource('pricelist_delete'))
                ->add(new Zend_Acl_Resource('pricelist_edit'))
                ->add(new Zend_Acl_Resource('catalogs_home'))
                ->add(new Zend_Acl_Resource('catalogs_view'))
                ->add(new Zend_Acl_Resource('catalogs_add'))
                ->add(new Zend_Acl_Resource('catalogs_delete'))
                ->add(new Zend_Acl_Resource('catalogs_edit'));

        $this->addRole(new Zend_Acl_Role(User::ADMIN))
                ->addRole(new Zend_Acl_Role(User::CUSTOMER))
                ->addRole(new Zend_Acl_Role(User::GUEST))
                ->addRole(new Zend_Acl_Role(User::SALESMAN));

        $this->deny(null);
        $this->allow(null, array('auth_auth', 'alert_news'))
                ->allow(array(
                    User::GUEST,
                    User::ADMIN
                        ), array(
                    'common_menubar',
                    'javascript_options',
                    'error_error',
                    'error_json',
                    'index_index',
                    'auth_login',
                    'auth_logout'))
                ->allow(User::ADMIN, array(
                    'upload_index',
                    'upload_upload',
                    'upload_result',
                    'salesman_searchhome',
                    'salesman_search',
                    'salesman_addhome',
                    'salesman_add',
                    'salesman_view',
                    'salesman_names',
                    'client_searchhome',
                    'client_search',
                    'client_addhome',
                    'client_add',
                    'client_view',
                    'pricelist_home',
                    'pricelist_upload',
                    'pricelist_view',
                    'pricelist_viewall',
                    'pricelist_delete',
                    'pricelist_edit',
                    'catalogs_home',
                    'catalogs_view',
                    'catalogs_add',
                    'catalogs_edit',
                    'catalogs_delete'
                ));
    }

    public static function getInstance() {

        if (null == self::$instance) {

            self::$instance = new self();
            self::$instance->initialize();
        }

        return self::$instance;
    }

}
