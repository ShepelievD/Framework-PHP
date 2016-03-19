<?php

namespace Framework\Session;

use Framework\DI\Service;

/**
 * Class Session
 * @package Framework\Session
 */

class Session {

    /**
     * Session constructor.
     */

    public function __construct() {
        session_start();
        Service::get('security')->generateFormToken();
    }

    /**
     * @param $name
     * @param $val
     */

    public function __set($name, $val) {
        $_SESSION[$name] = $val;
    }

    /**
     * @param $name
     * @return null
     */

    public function __get($name) {
        return array_key_exists($name, $_SESSION) ? $_SESSION[$name] : null;
    }

    /**
     * @param array $names
     */
    public function unset_data( $names = []) {
        foreach ($names as $item) {
            unset($_SESSION[$item]);
        }
    }

    /**
     * @param $type
     * @param $message
     */
    public function addFlush($type, $message) {

        $_SESSION['messages'][$type][] = $message;
    }
}