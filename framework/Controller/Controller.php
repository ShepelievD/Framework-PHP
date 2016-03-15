<?php

namespace Framework\Controller;


use Framework\Request\Request;
use Framework\Response\RedirectResponse;
use Framework\Response\Response;
use Framework\Renderer\Renderer;
use Framework\DI\Service;

class Controller{

    public function render( $template, $date ){

        $calledClassName = get_called_class();

        $viewDir = str_replace('Controller', '', str_replace('Blog\\Controller\\', '', $calledClassName));
        $template = __DIR__.'/../../src/Blog/views/'.$viewDir.'/'.$template.'.php';

        $renderer = new Renderer( );
        $content = $renderer->render( $template, $date );

        return new Response($content);
    }

    public function redirect( $uri ) {
        if( empty( $uri )) {
            $uri = '/';
        }
        return new RedirectResponse( $uri );
    }

    public function getRequest() {
        return new Request();
    }

    public function generateRoute( $name ) {
        return Service::get(['routes'])[$name]['pattern'];
    }
}