<?php

class My_Service_Customer {

    protected static $logger;

    public static function getDataFromCSV($fileName) {

        self::$logger = Zend_Registry::get('logger');
        self::$logger->info('Got fileName: ' . $fileName);

        $result = array(
            'duplicated' => array(),
            'valid' => array(),
            'invalid' => array()
        );

        $emailValidator = new Zend_Validate_EmailAddress();
        $emailValidator
                ->setMessage("%value% No es una direccion de correo electronico valida",
                        Zend_Validate_EmailAddress::INVALID)
                ->setMessage("%hostname% No es un dominio valido",
                        Zend_Validate_EmailAddress::INVALID_HOSTNAME)
                ->setMessage("%localpart% direccion de correo invalida",
                        Zend_Validate_EmailAddress::INVALID_LOCAL_PART);

        $telValidator = new Zend_Validate_Regex(My_Constant_Pattern::TELEPHONE);
        $telValidator->setMessage("%value% No es un telefono valido",
                Zend_Validate_Regex::NOT_MATCH);
        $telValidator->setMessage("%value% No es un telefono valido",
                Zend_Validate_Regex::INVALID);
        $serviceContact = new My_Service_Contact();

        if (($file = fopen($fileName, 'r')) !== false) {
            while (!feof($file)) {

                $line = fgets($file);
                $dataArray = explode(',', $line);

                foreach ($dataArray as $data) {

                    self::$logger->info('Data received:: ' . $data);

                    if ($emailValidator->isValid($data)) {

                        $contacts = $serviceContact->getByEmail($data);

                        if ($contacts) {

                            self::$logger->info('Duplicated email: ' . $data);
                            $result['duplicated'][] =
                                    array('data' => $data,
                                        'type' => 'email',
                                        'contact' => $contacts);
                        } else {

                            self::$logger->info('Valid email: ' . $data);
                            $result['valid'][] = array(
                                'data' => $data,
                                'type' => 'email',
                                'contact' => $serviceContact->createByEmail($data));
                        }
                    } else if ($telValidator->isValid($data)) {

                        $contacts = $serviceContact->getByTelephone($data);

                        if ($contacts) {

                            self::$logger->info('Duplicated telephone: ' . $data);
                            $result['duplicated'][] =
                                    array('data' => $data,
                                        'type' => 'telephonic',
                                        'contact' => $contacts);
                        } else {

                            self::$logger->info('Valid telephone: ' . $data);
                            $result['valid'][] = array(
                                'data' => $data,
                                'type' => 'telephonic',
                                'contact' => $serviceContact->createByTelephone($data));
                        }
                    } else {

                        self::$logger->info('Invalid data: ' . $data);
                        $result['invalid'][] =
                                array('data' => $data,
                                    'errors' => array_merge($emailValidator->getMessages(),
                                            $telValidator->getMessages())
                        );
                    }
                }
            }
        }


        return $result;
    }

    public function addCustomerData(array $contactsData) {

    }

    public static function getActiveByCriteria(array $searchFields = null) {

        $dql = Doctrine_Query::create()->from('Contact con')
                        ->leftJoin('con.Customer cus')
                        ->leftJoin('cus.Salesman sal')
                        ->leftJoin('con.Address add');

        if (null != $searchFields) {

            if (strlen($searchFields['client']['razon_social']) > 0) {
                $dql->where('cus.razon_social like ?',
                        $searchFields['client']['razon_social']);
            }

            if (strlen($searchFields['client']['representante_legal']) > 0) {
                $dql->where('cus.representante_legal like ?',
                        $searchFields['client']['representante_legal']);
            }

            if (strlen($searchFields['client']['nombre_comercial']) > 0) {
                $dql->where('cus.nombre_comercial like ?',
                        $searchFields['client']['nombre_comercial']);
            }

            if (strlen($searchFields['client']['rfc']) > 0) {
                $dql->where('cus.rfc like ?',
                        $searchFields['client']['rfc']);
            }

            if (strlen($searchFields['client']['giro_comercial']) > 0) {
                $dql->where('cus.giro_comercial like ?',
                        $searchFields['client']['giro_comercial']);
            }

            if (strlen($searchFields['contact']['first_name']) > 0) {
                $dql->where('con.first_name like ?',
                        $searchFields['contact']['first_name']);
            }

            if (strlen($searchFields['contact']['last_name']) > 0) {
                $dql->where('con.last_name like ?',
                        $searchFields['contact']['last_name']);
            }

            if (strlen($searchFields['contact']['email']) > 0) {
                $dql->where('con.email like ?',
                        $searchFields['contact']['email']);
            }

            if (strlen($searchFields['contact']['telephone']) > 0) {
                $dql->where('con.telephone like ?',
                        $searchFields['contact']['telephone']);
            }

            if (strlen($searchFields['address']['entre_calles']) > 0) {
                $dql->where('add.entre_calles like ?',
                        $searchFields['address']['entre_calles']);
            }

            if (strlen($searchFields['address']['colonia']) > 0) {
                $dql->where('add.colonia like ?',
                        $searchFields['address']['colonia']);
            }

            if (strlen($searchFields['address']['delegacion_municipio']) > 0) {
                $dql->where('add.delegacion_municipio like ?',
                        $searchFields['address']['delegacion_municipio']);
            }

            if (strlen($searchFields['address']['estado']) > 0) {
                $dql->where('add.estado like ?',
                        $searchFields['address']['estado']);
            }

            if (strlen($searchFields['address']['codigo_postal']) > 0) {
                $dql->where('add.codigo_postal like ?',
                        $searchFields['address']['codigo_postal']);
            }

            if (strlen($searchFields['address']['country']) > 0) {
                $dql->where('add.country like ?',
                        $searchFields['address']['country']);
            }
        }

        return $dql->execute();
    }

}
