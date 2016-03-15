<?php

namespace Framework\Request;

class Request {

    public function getMethod() {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function isPost() {
        return ( $this->getMethod() == 'POST' );
    }

    public function isGet() {
        return ( $this->getMethod() == 'GET') ;
    }

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

    public function post( $var = '', $typeFilter = 'string' ) {
        $result = null;

        if( array_key_exists( $var, $_POST )) {
            $result = $this->filter( $_POST[$var], $typeFilter );
        }
        return $result;
    }

    public function filter( $source, $typeFilter = 'string' ) {

        switch ( $typeFilter ) {
            case 'string':
                $result = filter_var( (string)$source, FILTER_SANITIZE_STRING );
                break;
            case 'e-mail':
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