<?php

class My_Form_Salesman_Add extends My_Form_Salesman_Abstract_Form {

    public function __construct(array $options = array()) {

        parent::__construct(array('isEditable' => true));
    }

    public function init() {

        parent::init();
        $this->setAttribs($this->getAttributes());
        $this->addElement('submit', 'addSalesman', array(
            'class' => 'button buttonSizeMedium',
            'label' => 'Agregar'
        ));

        $this->getElement('addSalesman')->removeDecorator('Label');
    }

    protected function getAttributes() {

        $viewHelperUrl = new Zend_View_Helper_Url();

        return array(
            'id' => 'salesmanAddForm',
            'enctype' => Zend_Form::ENCTYPE_MULTIPART,
            'action' => $viewHelperUrl->url(array(
                'controller' => 'salesman',
                'action' => 'add'
            ))
        );
    }

}
