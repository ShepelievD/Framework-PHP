<?php

namespace Framework\Response;

/**
 * Class ResponseRedirect
 * @package Framework\Response
 */

class ResponseRedirect extends Response {

    private $url;

    /**
     * ResponseRedirect constructor.
     *
     * @param string $url
     * @param string $content
     * @param string $type
     * @param int $code
     */

    public function __construct( $url, $content = '', $type = 'text/html', $code = 302 ) {
        parent::__construct( $content, $type, $code );
        $this->url = $url;
        $this->setHeader('Location', $this->url);
    }
}