<?php

class My_Service_Contact {

    protected $logger;

    public function __construct() {
        $this->logger = Zend_Registry::get('logger');
    }

    public static function createByEmail($email) {
        $contact = new Contact();
        $contact->email = $email;
        $contact->Customer->sales_group = My_Constant_SalesGroup::GROUP_1;
        $contact->save();
        return $contact;
    }

    public static function createByTelephone($telephone) {
        $contact = new Contact();
        $contact->telephone = $telephone;
        $contact->Customer->sales_group = My_Constant_SalesGroup::GROUP_1;
        $contact->save();
        return $contact;
    }

    public static function getByEmail($email) {
        return Doctrine_Query::create()
                ->from('Contact c')
                ->where('c.email = ?', array($email))
                ->fetchOne();
    }

    public static function getByTelephone($telephone) {
        return Doctrine_Query::create()
                ->from('Contact con')
                ->where('con.telephone = ?', array($telephone))
                ->fetchOne();
    }

}
