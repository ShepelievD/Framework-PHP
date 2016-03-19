<?php

namespace Framework\Security;

/**
 * Class Security
 * @package Framework\Security
 */

class Security {

    /**
     * Generates token
     *
     * @param string $form
     * @return string
     */

    public function generateFormToken( $form = '' ) {
        $token = md5( time() );
        $_SESSION[$form . '_token'] = $token;
        return $token;
    }

    /**
     * Verifies token
     *
     * @param string $form
     * @return bool
     */

    public function verifyFormToken( $form = '' ) {
        $result = true;

        if( isset( $_SESSION[$form . '_token'] ) or !isset($_POST['token']) ){
            $result = false;
        }

        return $result;
    }

    /**
     * Checks is user authenticated
     *
     * @return bool
     */

    public function isAuthenticated( ) {
        if ( $this->verifyFormToken() == false ) {
            return false;
        }
        return isset($_SESSION['isAuthenticated']) ? $_SESSION['isAuthenticated'] : false;
    }

    /**
     * Sets current user
     *
     * @param $user
     * @param string $userSessionName
     */
    public function setUser( $user, $userSessionName = 'user' ) {
        $_SESSION[$userSessionName] = $user;
        $_SESSION['isAuthenticated'] = true;
    }

    /**
     * Returns current user
     *
     * @param string $userSessionName
     * @return null
     */

    public function getUser( $userSessionName = 'user' ) {
        return isset( $_SESSION[$userSessionName] ) ? $_SESSION[$userSessionName] : null;
    }

    /**
     * Ends session
     */

    public function clear() {
        $_SESSION = [];
        session_destroy();
    }
}