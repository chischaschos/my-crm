<?php

class Zend_View_Helper_BaseUrl extends Zend_View_Helper_Abstract
{
    public function baseUrl()
    {
        $fc = Zend_Controller_Front::getInstance();
        return $fc->getBaseUrl();
    }
}

