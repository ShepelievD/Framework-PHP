<?php

namespace Framework\Request;

class Request {

    /**
     * Serves for getting method
     *
     * @return mixed
     */

    public function getMethod() {
        return $_SERVER[ 'REQUEST_METHOD' ];
    }

    /**
     * Checks is method came as POST or not
     *
     * @return bool
     */

    public function isPost() {
        return ( $this->getMethod() == 'POST' );
    }

    /**
     * Checks is method came as GET or not
     *
     * @return bool
     */

    public function isGet() {
        return ( $this->getMethod() == 'GET' );
    }

    /**
     * Returns headers
     *
     * @param null $header
     * @return array|false|null
     */

    public function getHeaders( $header = null ) {

        $data = apache_request_headers();

        if ( !empty( $header ) ) {
            $data = null;
            if( array_key_exists( $header, $data )) {
                $data = $data[$header];
            }
        }
        return $data;
    }

    /**
     * Gets variable by name from POST
     *
     * @param string $var
     * @param string $typeFilter
     * @return mixed|null
     */

    public function post( $var = '', $typeFilter = 'string' ) {
        $result = null;

        if( array_key_exists( $var, $_POST )) {
            $result = $this->filter( $_POST[$var], $typeFilter );
        }
        return $result;
    }

    /**
     * Method is filter for incoming information
     *
     * @param $source
     * @param string $typeFilter
     * @return mixed|null
     */

    public function filter( $source, $typeFilter = 'string' ) {

        switch ( $typeFilter ) {
            case 'string':
                $result = filter_var( (string)$source, FILTER_SANITIZE_STRING );
                break;
            case 'email':
                $result = filter_var( (string)$source, FILTER_VALIDATE_EMAIL );
                break;
            case 'int':
                $result = filter_var( (string)$source, FILTER_SANITIZE_NUMBER_INT );
                break;
            case 'float':
                $result = filter_var( (string)$source, FILTER_SANITIZE_NUMBER_FLOAT );
                break;
            default: $result = null;
        }

        return $result;
    }
}