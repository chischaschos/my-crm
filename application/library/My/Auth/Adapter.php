<?php

class My_Auth_Adapter implements Zend_Auth_Adapter_Interface {

    protected $username;
    protected $password;
    protected $logger;

    /**
     * Sets username and password for authentication
     *
     * @return void
     */
    public function __construct($username, $password) {

        $this->logger = Zend_Registry::get('logger');
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * Performs an authentication attempt
     *
     * @throws Zend_Auth_Adapter_Exception If authentication cannot
     *                                     be performed
     * @return Zend_Auth_Result
     */
    public function authenticate() {

        $this->logger->info('Authenticate vs username/password: ' .
                $this->username . '/' . $this->password);

        $user = Doctrine_Query::create()
                        ->from('User u')
                        ->where('u.name = ?', $this->username)
                        ->andWhere('u.password = ?', $this->password)
                        ->fetchOne();

        $authResult = null;


        if (!$user || User::GUEST === $user->role) {

            $this->logger->info('User not found');
            $authResult =
                    new Zend_Auth_Result(Zend_Auth_Result::SUCCESS,
                            Doctrine::getTable('User')->findOneByRole(User::GUEST));
        } else {

            $this->logger->info('Found user is : ' . print_r($user->toArray(), true));
            $authResult =
                    new Zend_Auth_Result(Zend_Auth_Result::SUCCESS, $user);
        }

        return $authResult;
    }

}
