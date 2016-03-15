<?php

namespace Framework;

use Framework\DI\Service;
use Framework\Exception\HttpNotFoundException;
use Framework\Exception\BadResponseTypeException;
use Framework\Renderer\Renderer;
use Framework\Response\Response;
use Framework\Router\Router;



/**
 * Class Application
 * @package Framework
 */

class Application {

    public function __construct( $path ) {

        if( file_exists( $path )) {
            Service::set('config', include($path));
            Service::set('routes', Service::get('config')['routes']);

            $pdoFromConfig = Service::get('config')['pdo'];
            $db = new \PDO( $pdoFromConfig['dns'], $pdoFromConfig['user'], $pdoFromConfig['password']);

            Service::set('db', $db);
        }
    }

    /**
     *  The method starts the app
     */
    public function run(){

        $router = new Router( Service::get('routes') );

        $route =  $router->parseRoute();

        Service::set('currentRoute', $route);

        try {
            if (!empty($route)) {
                $controllerReflection = new \ReflectionClass($route['controller']);

                $action = $route['action'] . 'Action';

                if ($controllerReflection->hasMethod($action)) {
                    if( $controllerReflection->isInstantiable() ) {
                        $controller = $controllerReflection->newInstance();
                        $actionReflection = $controllerReflection->getMethod($action);
                        $response = $actionReflection->invokeArgs($controller, $route['params']);
                    }
                    else {
                        throw new BadResponseTypeException('Bad response');
                    }
                }
                else {
                    throw new HttpNotFoundException('The page has not found');
                }
            }
            else {
                throw new HttpNotFoundException('The page has not found');
            }
        }
        catch( HttpNotFoundException $e ) {

            $renderer = new Renderer();

            $params = $e->getParams();
            $content = $renderer->render( Service::get('config')['error_500'], $params );

            $response = new Response( $content,'text/html', '404' );
        }
        catch( BadResponseTypeException $e) {

            $renderer = new Renderer();

            $params = $e->getParams();
            $content = $renderer->render( Service::get('config')['error_500'], $params );

            $response = new Response( $content, 'text/html', '500' );
        }
        catch( \Exception $e ) {
            $response = new Response( $e->getMessage(), 'text/html', '200' );
        }
        $response->send();
    }
}