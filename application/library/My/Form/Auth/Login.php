<?php

class My_Form_Auth_Login extends My_Form_BaseForm {

    public function init() {

        $this->addElements(array(
            array('text', 'username'),
            array('password', 'password'),
            array('submit', 'login',
                array('label' => 'Ingresar', 'class' => 'button buttonSizeMedium')
            )
        ));

        $this->getElement('login')->addDecorator('Label', array('tag' => 'div', 'class' => 'hidden'));

        $username = $this->username;
        $username->setLabel('Nombre de usuario');
        $username->setRequired(true);

        $password = $this->password;
        $password->setLabel('Clave');
        $password->setRequired(true);

        $this->setElementFilters(array('StringTrim'));
        $this->setAttribs($this->getAttributes());
    }

    private function getAttributes() {

        $viewHelperUrl = new Zend_View_Helper_Url();

        return array(
            'id' => 'loginForm',
            'enctype' => Zend_Form::ENCTYPE_MULTIPART,
            'action' => $viewHelperUrl->url(array(
                'controller' => 'auth',
                'action' => 'auth'
            ))
        );
    }

}
