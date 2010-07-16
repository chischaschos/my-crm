<?php

class My_Service_Catalogs {

    protected static $logger;

    /**
     *
     * @return array PricelistCategory
     */
    public static function getPricelistCategory() {

        return Doctrine_Query::create()->from('PricelistCategory')->execute();
    }

    public static function addPricelistCategory(array $pricelistCategory) {

        /*
         * We unset id since by default its form adds an id field
         */
        unset($pricelistCategory['id']);
        $plCategory = new PricelistCategory();
        $plCategory->merge($pricelistCategory);
        $plCategory->save();

        return $plCategory;
    }

    /**
     *
     * @param int $pricelistCategoryId
     * @return boolean True if the category was removed false otherwise, false
     * comes when category doesn't exist or has an existing Pricelist
     *
     */
    public static function removePricelistCategory($pricelistCategoryId) {

        $existingPricelist = Doctrine::getTable('PricelistCategory')
                        ->findOneById($pricelistCategoryId);

        $status = null;

        if (!$existingPricelist || $existingPricelist->Pricelist->exists()) {

            $status = false;
        } else {

            $status = true;
            Doctrine_Query::create()->delete('PricelistCategory plc')
                    ->where('plc.id = ?', array($pricelistCategoryId))->execute();
        }

        return $status;
    }

    public static function existsPricelistCategory(array $pricelistCategory) {

        return (boolean) Doctrine_Query::create()->from('PricelistCategory plc')
                ->where('plc.category_name = ?', array($pricelistCategory['category_name']))
                ->fetchOne();
    }

}
