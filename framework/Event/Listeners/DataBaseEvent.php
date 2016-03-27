<?php

namespace Framework\Event\Listeners;

use Framework\DI\Service;

/**
 * Class DataBaseEvent
 * @package Framework\Event\Listeners
 */
class DataBaseEvent {

    /**
     * Sets utf-8 for correct displaying DB queries
     */

    public function setUTF8(){
        $db = Service::get('db');
        $db->exec('SET NAMES utf8');
    }

    /**
     * Closes DB connection
     */

    public function closeDB(){
        Service::set('db', null);
    }

}