<?php

class My_Form_Catalogs_PricelistCategory extends My_Form_BaseForm {

    public function init() {

        $this->addElements(array(
            array('text', 'category_name',
                array('label' => 'Nombre',
                    'validators' => array(
                        array('regex', true, array(My_Constant_Pattern::LETTERS_WBASIC_INPUT)),
                    )
                )
            ),
            array('text', 'description',
                array('label' => 'Description',
                    'validators' => array(
                        array('regex', true, array(My_Constant_Pattern::LETTERS_WBASIC_INPUT))
                    )
                )
            ),
            array('hidden', 'id',
                array('validators' => array('int'))
            ),
            array('submit', 'add',
                array('label' => 'Agregar', 'class' => 'button buttonSizeMedium')
            ),
        ));

        $this->getElement('add')->removeDecorator('Label');

        $this->addDisplayGroup(array('category_name', 'description', 'id', 'add'),
                'detail');
        $this->setElementFilters(array('StringTrim'));
        $this->setAttribs($this->getAttributes());
    }

    private function getAttributes() {

        $viewHelperUrl = new Zend_View_Helper_Url();

        return array(
            'id' => 'pricelistCategoryForm',
            'enctype' => Zend_Form::ENCTYPE_MULTIPART
        );
    }

}
