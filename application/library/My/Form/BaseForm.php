<?php

class My_Form_BaseForm extends Zend_Form {

    public function __construct() {

        parent::__construct(array(
                    'decorators' => array(
                        'FormElements', 'Form'
                    ),
                    'elementDecorators' => array(
                        'ViewHelper',
                        array('Label', array('tag' => 'div', 'class' => 'inputLabel'))
                    ),
                        /* 'displayGroupDecorators' => array(
                          'FormElements',
                          'Fieldset'
                          ) */
                ));

        $this->setDisplayGroupDecorators(array('FormElements', 'Fieldset'));
    }

}
