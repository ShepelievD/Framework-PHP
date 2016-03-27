<?php

namespace Framework\Session;

/**
 * Class Session
 * @package Framework\Session
 */

class Session {

    /**
     * Session constructor.
     */
    public function __construct() {
        $this->startSession();
    }

    /**
     * Checks does SESSION has the parameter
     *
     * @param $parameter
     * @return bool
     */
    public function hasParameter( $parameter ) {
        return array_key_exists( $parameter, $_SESSION );
    }

    /**
     * Puts $parameter in SESSION.
     * If $rewrite is true than rewrites existing value on $value
     *
     * @param $parameter
     * @param $value
     * @param bool|true $rewrite
     */

    public function putParameter( $parameter, $value, $rewrite = true ) {
        if( $this->hasParameter( $parameter ) ){
            if( $rewrite ){
                $_SESSION[ $parameter ] = $value;
            }
        }else{
            $_SESSION[ $parameter ] = $value;
        }
    }

    /**
     * Removes parameter from SESSION
     *
     * @param $parameter
     */

    public function removeParameter ( $parameter ) {
        if( $this->hasParameter( $parameter ) ){
            unset( $_SESSION[ $parameter ] );
        }
    }

    /**
     * Returns parameter from SESSION
     *
     * @param $parameter
     * @return null
     */

    public function getParameter ($parameter) {
        $result = null;
        if( $this->hasParameter( $parameter ) ){
            $result = $_SESSION[ $parameter ];
        }
        return $result;
    }

    /**
     * Starts the sessions
     */
    private function startSession() {
        if( session_status() == PHP_SESSION_NONE ){
            session_start();
        }
    }

}