<?php

class My_Service_Pricelist {

    public static function getAll() {

        return Doctrine::getTable("Pricelist")->findAll();
    }

    /**
     *
     * @param int $pricelistId
     * @return int number of deleted elements
     */
    public static function deleteById($pricelistId) {

        return Doctrine_Query::create()
                ->delete('Pricelist p')
                ->where('p.id = ?', array($pricelistId))
                ->execute();
    }

    public static function getRawById($pricelistId) {

        $pricelist = Doctrine_Query::create()
                        ->from('Pricelist p')
                        ->where('p.id = ?', array($pricelistId))
                        ->fetchOne();

        header("Content-length: " . $pricelist->size);
        header("Content-type: " . $pricelist->contenttype);
        header("Content-Disposition: attachment; filename=" . $pricelist->name);

        echo $pricelist->content;
    }

    /**
     * Updates parameter pricelist array
     *
     * @param array $paramPricelist
     * @return boolean True if update was successful false otherwise
     */
    public static function update(array $paramPricelist) {

        $result = false;
        $pricelistCategory = Doctrine::getTable('PricelistCategory')->findOneById($paramPricelist['category']);

        if ($pricelistCategory->exists()) {

            $pricelist = Doctrine::getTable('Pricelist')->findOneById($paramPricelist['id']);
            $pricelist->name = $paramPricelist['name'];
            $pricelist->description = $paramPricelist['description'];
            $pricelist->PricelistCategory = $pricelistCategory;
            $pricelist->save();

            $result = true;
        }

        return $result;
    }

}
