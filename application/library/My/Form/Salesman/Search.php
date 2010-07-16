<?php

class My_Form_Salesman_Search extends My_Form_Salesman_Abstract_Form {

    public function __construct(array $options = array()) {

        parent::__construct(array('isEditable' => true));
    }

    public function init() {

        parent::init();
        $this->setAttribs($this->getAttributes());
        $this->addElement('submit', 'searchSalesman', array(
            'class' => 'button buttonSizeMedium',
            'label' => 'Search'
        ));

        $this->getSubForm('salesman')->getElement('first_name')
                ->setRequired(false);
        $this->getSubForm('salesman')->getElement('last_name')
                ->setRequired(false);
    }

    protected function getAttributes() {

        $viewHelperUrl = new Zend_View_Helper_Url();

        return array(
            'id' => 'salesmanSearchForm',
            'enctype' => Zend_Form::ENCTYPE_MULTIPART,
            'action' => $viewHelperUrl->url(array(
                'controller' => 'salesman',
                'action' => 'search'
            ))
        );
    }

}
