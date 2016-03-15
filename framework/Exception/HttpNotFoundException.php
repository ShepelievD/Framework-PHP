<?php

namespace Framework\Exception;

/**
 * Class serves for throwing exception in case "404"
 *
 * Class HttpNotFoundException
 * @package Framework\Exception
 */

class HttpNotFoundException extends \Exception {
    public function getParams( ) {
        $params = [ 'message' => $this->getMessage(), 'code' => '404'];
        return $params;
    }
}