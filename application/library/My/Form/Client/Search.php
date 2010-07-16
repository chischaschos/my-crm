<?php

class My_Form_Client_Search extends My_Form_Client_Abstract_Form {

    public function __construct(array $options = array()) {

        parent::__construct(array('isEditable' => true));
    }

    public function init() {

        parent::init();
        $this->addElements(array(
            array('submit', 'Buscar'),
            array('button', 'Limpiar')
        ));
        $this->setAttribs($this->getAttributes());
    }

    protected function getAttributes() {

        $viewHelperUrl = new Zend_View_Helper_Url();

        return array(
            'id' => 'clientSearchForm',
            'enctype' => Zend_Form::ENCTYPE_MULTIPART,
            'action' => $viewHelperUrl->url(array(
                'controller' => 'client',
                'action' => 'searchhome'
            ))
        );
    }

}
