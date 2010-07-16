<?php

abstract class My_Form_Client_Abstract_Form extends My_Form_BaseForm {

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

        $clientSubForm = new Zend_Form_SubForm($subFormOptions);
        $clientSubForm->setLegend('Cliente');
        $clientSubForm->addElements(array(
            array('text', 'razon_social', $baseElementOptions),
            array('text', 'representante_legal', $baseElementOptions),
            array('text', 'nombre_comercial', $baseElementOptions),
            array('text', 'rfc', array('validators' => array(
                        array('regex', true, array(My_Constant_Pattern::RFC))
                    )
                )
            ),
            array('text', 'giro_comercial', $baseElementOptions),
        ));

        $contactSubForm = new Zend_Form_SubForm($subFormOptions);
        $contactSubForm->setLegend('Contacto');
        $contactSubForm->addElements(array(
            array('text', 'first_name', $baseElementOptions),
            array('text', 'last_name', $baseElementOptions),
            array('text', 'email', array('validators' => array(
                        array('EmailAddress', true)))
            ),
            array('text', 'telephone', array('validators' => array(
                        array('regex', true, array(My_Constant_Pattern::TELEPHONE))
                    )
                )
            ),
        ));

        $addressSubForm = new Zend_Form_SubForm($subFormOptions);
        $addressSubForm->setLegend('Direccion');
        $addressSubForm->addElements(array(
            array('text', 'entre_calles', $baseElementOptions),
            array('text', 'colonia', $baseElementOptions),
            array('text', 'delegacion_municipio', $baseElementOptions),
            array('text', 'estado', $baseElementOptions),
            array('text', 'codigo_postal', array('validators' => array('int'))),
            array('text', 'country', $baseElementOptions),
        ));

        $this->addSubForms(array(
            'contact' => $contactSubForm,
            'client' => $clientSubForm,
            'address' => $addressSubForm,
        ));

        $razonSocial = $this->getSubForm('client')->razon_social;
        $razonSocial->setAttrib($disabled, $disabled);
        $razonSocial->setLabel('Razon social');

        $legalRep = $this->getSubForm('client')->representante_legal;
        $legalRep->setAttrib($disabled, $disabled);
        $legalRep->setLabel('Representante legal');

        $nombreComercial = $this->getSubForm('client')->nombre_comercial;
        $nombreComercial->setAttrib($disabled, $disabled);
        $nombreComercial->setLabel('Nombre comercial');

        $rfc = $this->getSubForm('client')->rfc;
        $rfc->setAttrib($disabled, $disabled);
        $rfc->setLabel('RFC');

        $giro = $this->getSubForm('client')->giro_comercial;
        $giro->setAttrib($disabled, $disabled);
        $giro->setLabel('Giro comercial:');

        $firstName = $this->getSubForm('contact')->first_name;
        $firstName->setAttrib($disabled, $disabled);
        $firstName->setLabel('Nombre(s)');

        $lastName = $this->getSubForm('contact')->last_name;
        $lastName->setAttrib($disabled, $disabled);
        $lastName->setLabel('Apellido(s)');

        $email = $this->getSubForm('contact')->email;
        $email->setAttrib($disabled, $disabled);
        $email->setLabel('Correo electronico');

        $telephone = $this->getSubForm('contact')->telephone;
        $telephone->setAttrib($disabled, $disabled);
        $telephone->setLabel('Telefono(s)');

        $surroundingStreets = $this->getSubForm('address')->entre_calles;
        $surroundingStreets->setAttrib($disabled, $disabled);
        $surroundingStreets->setLabel('Entre calles');

        $colonia = $this->getSubForm('address')->colonia;
        $colonia->setAttrib($disabled, $disabled);
        $colonia->setLabel('Colonia');

        $municipio = $this->getSubForm('address')->delegacion_municipio;
        $municipio->setAttrib($disabled, $disabled);
        $municipio->setLabel('Delegacion o municipio');

        $state = $this->getSubForm('address')->estado;
        $state->setAttrib($disabled, $disabled);
        $state->setLabel('Estado');

        $country = $this->getSubForm('address')->country;
        $country->setAttrib($disabled, $disabled);
        $country->setLabel('Pais');

        $postalCode = $this->getSubForm('address')->codigo_postal;
        $postalCode->setAttrib($disabled, $disabled);
        $postalCode->setLabel('Codigo postal');

        $this->setElementFilters(array('StringTrim'));
        $this->setAttribs($this->getAttributes());
    }

    protected abstract function getAttributes();
}
