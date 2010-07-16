<?php

class My_Form_Upload extends My_Form_BaseForm {

    public function init() {

        $this->addElements(array(
            array('submit', 'submit',
                array('label' => 'Subir', 'class' => 'button buttonSizeMedium')
            ),
            array('file', 'file',
                array('label' => 'Archivo a subir',
                    'class' => 'button buttonSizeMedium',
                    'decorators' => array('File')
                )
            )
        ));

        $this->submit->removeDecorator('Label');

        $this->setAttribs($this->getAttributes());
    }

    private function getAttributes() {

        $viewHelperUrl = new Zend_View_Helper_Url();

        return array(
            'id' => 'fileUploadForm',
            'enctype' => Zend_Form::ENCTYPE_MULTIPART,
            'target' => 'uploadIfrm',
            'action' => $viewHelperUrl->url(array(
                'controller' => 'upload',
                'action' => 'upload'))
        );
    }

}
