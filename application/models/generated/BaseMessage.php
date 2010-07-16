<?php

/**
 * BaseMessage
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $subject
 * @property string $body
 * @property integer $user_id
 * @property boolean $is_read
 * @property User $User
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 5441 2009-01-30 22:58:43Z jwage $
 */
abstract class BaseMessage extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('message');
        $this->hasColumn('id', 'integer', 4, array('primary' => true, 'autoincrement' => true, 'type' => 'integer', 'length' => '4'));
        $this->hasColumn('subject', 'string', 50, array('type' => 'string', 'length' => '50'));
        $this->hasColumn('body', 'string', 200, array('type' => 'string', 'length' => '200'));
        $this->hasColumn('user_id', 'integer', 4, array('type' => 'integer', 'length' => '4'));
        $this->hasColumn('is_read', 'boolean', null, array('type' => 'boolean', 'default' => false));
    }

    public function setUp()
    {
        $this->hasOne('User', array('local' => 'user_id',
                                    'foreign' => 'id'));

        $timestampable0 = new Doctrine_Template_Timestampable(array('created' => array('type' => 'timestamp'), 'updated' => array('type' => 'timestamp')));
        $this->actAs($timestampable0);
    }
}