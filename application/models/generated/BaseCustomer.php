<?php

/**
 * BaseCustomer
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $razon_social
 * @property string $representante_legal
 * @property string $nombre_comercial
 * @property string $rfc
 * @property string $giro_comercial
 * @property integer $salesman_id
 * @property string $sales_group
 * @property integer $user_id
 * @property integer $pricelist_category_id
 * @property User $User
 * @property Contact $Contact
 * @property Salesman $Salesman
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 5441 2009-01-30 22:58:43Z jwage $
 */
abstract class BaseCustomer extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('customer');
        $this->hasColumn('id', 'integer', 4, array('primary' => true, 'autoincrement' => true, 'type' => 'integer', 'length' => '4'));
        $this->hasColumn('razon_social', 'string', 50, array('type' => 'string', 'length' => '50'));
        $this->hasColumn('representante_legal', 'string', 50, array('type' => 'string', 'length' => '50'));
        $this->hasColumn('nombre_comercial', 'string', 50, array('type' => 'string', 'length' => '50'));
        $this->hasColumn('rfc', 'string', 20, array('type' => 'string', 'length' => '20'));
        $this->hasColumn('giro_comercial', 'string', 20, array('type' => 'string', 'length' => '20'));
        $this->hasColumn('salesman_id', 'integer', 4, array('type' => 'integer', 'length' => '4'));
        $this->hasColumn('sales_group', 'string', 10, array('type' => 'string', 'length' => '10'));
        $this->hasColumn('user_id', 'integer', 4, array('type' => 'integer', 'length' => '4'));
        $this->hasColumn('pricelist_category_id', 'integer', 4, array('type' => 'integer', 'length' => '4'));
    }

    public function setUp()
    {
        $this->hasOne('User', array('local' => 'user_id',
                                    'foreign' => 'id'));

        $this->hasOne('Contact', array('local' => 'id',
                                       'foreign' => 'customer_id'));

        $this->hasOne('Salesman', array('local' => 'salesman_id',
                                        'foreign' => 'id'));

        $timestampable0 = new Doctrine_Template_Timestampable(array('created' => array('type' => 'timestamp'), 'updated' => array('type' => 'timestamp')));
        $this->actAs($timestampable0);
    }
}