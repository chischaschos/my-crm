<?php

/**
 * BaseDocument
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property string $contenttype
 * @property integer $size
 * @property blob $content
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 5441 2009-01-30 22:58:43Z jwage $
 */
abstract class BaseDocument extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('document');
        $this->hasColumn('id', 'integer', 4, array('primary' => true, 'autoincrement' => true, 'type' => 'integer', 'length' => '4'));
        $this->hasColumn('name', 'string', 30, array('type' => 'string', 'length' => '30'));
        $this->hasColumn('contenttype', 'string', 30, array('type' => 'string', 'length' => '30'));
        $this->hasColumn('size', 'integer', 11, array('type' => 'integer', 'length' => '11'));
        $this->hasColumn('content', 'blob', null, array('type' => 'blob'));
    }

    public function setUp()
    {
        $timestampable0 = new Doctrine_Template_Timestampable(array('created' => array('type' => 'timestamp'), 'updated' => array('type' => 'timestamp')));
        $this->actAs($timestampable0);
    }
}