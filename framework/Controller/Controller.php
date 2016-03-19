<?php

namespace Framework\Controller;


use Framework\Request\Request;
use Framework\Response\ResponseRedirect;
use Framework\Response\Response;
use Framework\Renderer\Renderer;
use Framework\DI\Service;

/**
 * Class Controller
 * @package Framework\Controller
 */

class Controller{

    /**
     * For rendering
     *
     * @param $template
     * @param $date
     * @return Response
     */

    public function render( $template, $date ){

        $calledClassName = get_called_class();

        $viewDir = str_replace('Controller', '', str_replace('Blog\\Controller\\', '', $calledClassName));
        $template = __DIR__.'/../../src/Blog/views/'.$viewDir.'/'.$template.'.php';

        $renderer = new Renderer( );
        $content = $renderer->render( $template, $date );

        return new Response($content);
    }

    /**
     * Redirect
     *
     * @param $uri
     * @param string $message
     * @return ResponseRedirect
     */

    public function redirect( $uri, $message = '' ) {
        if( empty( $uri )) {
            $uri = '/';
        }

        return new ResponseRedirect( $uri, $message );
    }

    /**
     * Get Request
     *
     * @return Request
     */

    public function getRequest() {
        return new Request();
    }

    /**
     * Generate route for redirect or etc.
     *
     * @param $name
     * @return mixed
     */

    public function generateRoute( $name ) {
        return Service::get(['routes'])[$name]['pattern'];
    }
}