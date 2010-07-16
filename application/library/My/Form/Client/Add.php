<?php

class My_Form_Client_Add extends My_Form_Client_Abstract_Form {

    public function __construct(array $options = array()) {

        parent::__construct(array('isEditable' => true));
    }

    public function init() {

        parent::init();
        $this->getSubForm('client')->addElement(
                'select', 'sales_group', array(
            'validators' => array(
                'NotEmpty'
            )
                )
        );

        $this->getSubForm('contact')->addElements(array(
            array('radio', 'sal_assign_type', array(
                    'validators' => array(
                        'NotEmpty'
                    )
            )),
            array('select', 'salesman_select'),
            array('hidden', 'salesman', array('validators' => array('int')))
        ));


        $salesGroup = $this->getSubForm('client')->sales_group;
        $salesGroup->setLabel('Grupo de ventas');
        $salesGroup->addMultiOptions(array(
            My_Constant_SalesGroup::GROUP_1 => 'Group 1',
            My_Constant_SalesGroup::GROUP_2 => 'Group 2'
        ));

        $salAssignType = $this->getSubForm('contact')->sal_assign_type;
        $salAssignType->addMultiOptions(array(
            'auto' => 'Automatico',
            'manu' => 'Manual'
        ));
        $salAssignType->setLabel('Tipo de asignacion de vendedor');

        $salesman = $this->getSubForm('contact')->salesman_select;
        $salesman->setLabel('Selecciona un vendedor');
        $salesman->addValidator('digits', true);
    }

    protected function getAttributes() {

        $viewHelperUrl = new Zend_View_Helper_Url();

        return array(
            'id' => 'clientAddForm',
            'enctype' => Zend_Form::ENCTYPE_MULTIPART,
            'action' => $viewHelperUrl->url(array(
                'controller' => 'client',
                'action' => 'add'
            ))
        );
    }

}
