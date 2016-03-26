<?php

namespace Framework\Exception;

/**
 * Class serves for catching bad responses
 *
 * Class BadResponseTypeException
 * @package Framework\Exception
 */


class BadResponseTypeException extends \Exception {

    public function getParams( ) {
        $params = [ 'message' => $this->getMessage(), 'code' => '500'];
        return $params;
    }
}