<?php

class My_Service_Salesman {

    protected static $logger;

    public static function assingCustomers(array $validCustomers) {

        self::$logger = Zend_Registry::get('logger');
        self::$logger->info(__CLASS__ . '::' . __FUNCTION__ . ' Got here');

        foreach ($validCustomers as $customerData) {

            self::$logger->info($customerData['contact']->id);
            self::$logger->info($customerData['contact']->Customer->id);

            $salesman = self::getNextAvailable();
            self::$logger->info($salesman->id);
            $salesman->Customers[] = $customerData['contact']->Customer;
            $salesman->save();
        }
    }

    /**
     * Returns the next salesman available to be assigned to one customer
     *
     * @return Salesman
     */
    public static function getNextAvailable() {

        $salesman = Doctrine_Query::create()
                        ->select('s.*, count(c.id) as count')
                        ->from('Salesman s')
                        ->leftJoin('s.Customers c')
                        ->groupBy('s.id')
                        ->orderBy('count asc')
                        ->fetchOne();

        return $salesman;
    }

    public static function getNames() {

        return Doctrine_Query::create()
                ->select('id, first_name, last_name')
                ->from('Salesman s')
                ->orderBy('last_name asc, first_name asc')
                ->fetchArray();
    }

    public static function
    getActiveByCriteria(array $searchFields = null) {

        $dql = Doctrine_Query::create()->from('Salesman sal')
                        ->leftJoin('sal.Address add');

        if (null != $searchFields) {

            if (strlen($searchFields['salesman']['first_name']) > 0) {
                $dql->where('sal.first_name like ?',
                        $searchFields['salesman']['first_name']);
            }

            if (strlen($searchFields['salesman']['last_name']) > 0) {
                $dql->where('sal.last_name like ?',
                        $searchFields['salesman']['last_name']);
            }

            if (strlen($searchFields['salesman']['email']) > 0) {
                $dql->where('sal.email like ?',
                        $searchFields['salesman']['email']);
            }

            if (strlen($searchFields['salesman']['telephone']) > 0) {
                $dql->where('sal.telephone like ?',
                        $searchFields['salesman']['telephone']);
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
