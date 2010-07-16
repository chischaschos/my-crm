<?php

class My_Service_Message {

    protected static $logger;

    public static function create(array $options) {

        self::$logger = Zend_Registry::get('logger');
        $message = new Message();
        $message->User = $options['user'];
        $message->subject = $options['subject'];
        $message->body = $options['body'];
        self::$logger->info(__CLASS__ . print_r($message->toArray(), true));
        $message->save();
    }

    /**
     *
     * Returns the latest not read messages post for some parameter user id
     *
     * @param userID
     * @param returnFullData
     * @return array||User
     */
    public static function getLatestByUser($userId, $returnFullData) {

        return Doctrine_Query::create()
                ->select($returnFullData ? 'm.*' : 'm.subject, m.body')
                ->from('Message m ')
                ->where('m.User.id = ?', $userId)
                ->andWhere("m.is_read = false")
                ->execute();
    }

}
