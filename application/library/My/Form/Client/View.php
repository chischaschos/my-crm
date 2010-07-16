<?php

class My_Form_Client_View extends My_Form_Client_Abstract_Form {

    public function __construct() {

        parent::__construct(array('isEditable' => false));
    }

    public function init() {

        parent::init();
        $this->getSubForm('client')->addElement('text', 'sales_group',
                array('label' => 'Grupo de ventas', 'disabled' => 'disabled'));
    }

    protected function getAttributes() {

        $viewHelperUrl = new Zend_View_Helper_Url();

        return array(
            'id' => 'clientViewForm',
            'enctype' => Zend_Form::ENCTYPE_MULTIPART
        );
    }

}
