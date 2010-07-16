<?php
include '../../../application/global.php';
$application = new Zend_Application(
    APPLICATION_ENV, 
    APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap();

/*foreach(My_Service_Pricelist::getAll() as $p) {

	var_dump($p->toArray(p);

}*/

echo My_Service_Pricelist::update(array('id' => 1,'name' => 'pepepe', 'description' => 'lallala', 'category' => '1'));

//$pricelistCategory = Doctrine::getTable('PricelistCategory')->findOneById(1);
//
//            $pricelist = Doctrine::getTable('Pricelist')->findOneById(1);
//            //var_dump($pricelist->toArray());
//            $pricelist->name = 'vergobre';
//            $pricelist->description ='description';
//            $pricelist->PricelistCategory = $pricelistCategory;
//            $pricelist->save();