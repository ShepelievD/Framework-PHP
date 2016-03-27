<?php

namespace Framework\Controller;


use Framework\Request\Request;
use Framework\Response\ResponseRedirect;
use Framework\Response\Response;
use Framework\Renderer\Renderer;
use Framework\Router\Router;
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

        $segments = explode('\\',$calledClassName);

        $bundleName = $segments[0];
        $controllerName = $segments[2];

        $controllerName = str_replace('Controller', '', $controllerName);

        $template = realpath(__DIR__.'/../../src/'.$bundleName.'/views/'.$controllerName.'/'.$template.'.php');

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
     * @param null $id
     * @return mixed
     */

    public function generateRoute( $name, $id = null ) {

        $routes = Service::get('routes');
        $url = $routes[$name]['pattern'];

        if(!is_null($id)){
            $url = str_replace('{id}', $id, $url);
        }
        return $url;
    }
}