<?php

abstract class My_Form_Salesman_Abstract_Form extends My_Form_BaseForm {

    private $isEditable;

    public function __construct(array $options) {

        $this->isEditable = isset($options['isEditable']) ?
                $options['isEditable'] : true;

        parent::__construct();
    }

    public function init() {


        /*
         * We disable elements when we're just going to show data
         */
        $disabled = $this->isEditable ? '' : 'disabled';

        $subFormOptions = array(
            'decorators' => array(
                'FormElements', 'Fieldset'
            ),
            'elementDecorators' => array(
                'ViewHelper',
                array('Label', array('tag' => 'div', 'class' => 'inputLabel'))
            )
        );

        $baseElementOptions = array(
            'validators' => array(
                array(
                    'regex', true, array(
                        My_Constant_Pattern::LETTERS_WBASIC_INPUT
                    )
                )
            )
        );

        $salesmanSubForm = new Zend_Form_SubForm($subFormOptions);
        $salesmanSubForm->setLegend('Vendedor');
        $salesmanSubForm->addElements(array(
            array('text', 'first_name', array_merge(
                        array(
                            'label' => 'Nombre(s)',
                            $disabled => $disabled
                        ),
                        $baseElementOptions
                )
            ),
            array('text', 'last_name', array_merge(
                        array(
                            'label' => 'Apellido(s)',
                            $disabled => $disabled
                        ), $baseElementOptions
                )
            ),
            array('text', 'email', array(
                    'label' => 'Correo electronico',
                    $disabled => $disabled,
                    'validators' => array(
                        array('EmailAddress', true)
                    )
                )
            ),
            array('text', 'telephone', array(
                    'label' => 'Telefono', $disabled => $disabled,
                    'validators' => array(
                        array('regex', true, array(My_Constant_Pattern::TELEPHONE))
                    )
                )
            )
        ));

        $salesmanSubForm->first_name->setRequired(true);
        $salesmanSubForm->last_name->setRequired(true);

        $addressSubForm = new Zend_Form_SubForm($subFormOptions);
        $addressSubForm->setLegend('Direccion');
        $addressSubForm->addElements(array(
            array('text', 'entre_calles', array_merge(
                        $baseElementOptions, array('label' => 'Entre calles', $disabled => $disabled)
                )
            ),
            array('text', 'colonia', array_merge(
                        $baseElementOptions, array('label' => 'Colonia', $disabled => $disabled)
                )
            ),
            array('text', 'delegacion_municipio', array_merge(
                        $baseElementOptions, array('label' => 'Delegacion o municipio', $disabled => $disabled)
                )
            ),
            array('text', 'estado', array_merge(
                        $baseElementOptions, array('label' => 'Estado', $disabled => $disabled)
                )
            ),
            array('text', 'codigo_postal', array(
                    'validators' => array('int'), 'label' => 'Codigo postal', $disabled => $disabled
                )
            ),
            array('text', 'country', array_merge(
                        $baseElementOptions, array('label' => 'Pais', $disabled => $disabled)
                )
            )
        ));

        $this->addSubForms(array(
            'salesman' => $salesmanSubForm,
            'address' => $addressSubForm
        ));
        $this->setElementFilters(array('StringTrim'));
    }

    protected abstract function getAttributes();
}
