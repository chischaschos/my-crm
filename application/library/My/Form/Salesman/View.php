<?php

class My_Form_Salesman_View extends My_Form_Salesman_Abstract_Form {

    public function __construct(array $options = array()) {

        parent::__construct(array('isEditable' => false));
    }

    public function init() {

        parent::init();
        $this->setAttribs($this->getAttributes());
    }

    protected function getAttributes() {

        $viewHelperUrl = new Zend_View_Helper_Url();

        return array(
            'id' => 'salesmanViewForm'
        );
    }

}
