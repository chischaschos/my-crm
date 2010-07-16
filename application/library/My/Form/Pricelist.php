<?php

class My_Form_Pricelist extends My_Form_BaseForm {

    public function init() {

        $this->addElements(array(
            array('text', 'name',
                array('label' => 'Nombre',
                    'validators' => array(
                        array('regex', true, array(My_Constant_Pattern::LETTERS_WBASIC_INPUT))))
            ),
            array('text', 'description',
                array('label' => 'Descripción',
                    'validators' => array(
                        array('regex', true, array(My_Constant_Pattern::LETTERS_WBASIC_INPUT))))
            ),
            array('select', 'category',
                array('label' => 'Categoria',
                    'validators' => array(
                        array('Int', true)))
            ),
            array('hidden', 'id',
                array('validators' => array(
                        array('Int', true)))
            )
        ));

        $categories = array();

        foreach (My_Service_Catalogs::getPricelistCategory() as $category) {

            $categories[$category->id] = $category->category_name;
        }

        $this->getElement('category')->addMultiOptions($categories);

        $this->addDisplayGroup(array('name', 'description', 'category', 'id'),
                'pricelist');
        $this->setElementFilters(array('StringTrim'));
        $this->setAttribs($this->getAttributes());
    }

    private function getAttributes() {

        $viewHelperUrl = new Zend_View_Helper_Url();

        return array(
            'id' => 'pricelistForm',
            'enctype' => Zend_Form::ENCTYPE_MULTIPART,
            'action' => $viewHelperUrl->url(
                    array('controller' => 'pricelist',
                        'action' => 'edit')
            )
        );
    }

}
