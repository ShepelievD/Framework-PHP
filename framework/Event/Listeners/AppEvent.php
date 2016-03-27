<?php

namespace Framework\Event\Listeners;
use Framework\DI\Service;
use Framework\Session\Session;
use Framework\Security\Security;

/**
 * Class AppEvent
 * @package Framework\Event\Listeners
 */

class AppEvent {

    /**
     * Inits Services at Application
     */

    public function init(){
        Service::set('routes', Service::get('config')['routes']);
        Service::set('session', new Session());
        Service::set('security', new Security());

        $pdoFromConfig = Service::get('config')['pdo'];
        $db = new \PDO( $pdoFromConfig['dns'], $pdoFromConfig['user'], $pdoFromConfig['password']);

        Service::set('db', $db);
    }
}