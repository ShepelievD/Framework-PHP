<?php

namespace Framework\Response;

class RedirectResponse extends Response {

    public function __construct( $url, $content = '', $type = 'text/html', $code = 302 ) {

        parent::__construct( $content, $type, $code );
        $this->setHeader( 'Location: ', $url );
    }
}