<?php

namespace Framework;

use Framework\Exception\BadResponseTypeException;
use Framework\Router\Router;
use Framework\Exception\HttpNotFoundException;

/**
 * Class Application
 * @package Framework
 */

class Application {

    /**
     *  The method starts the app
     */
    public function run(){

        $router = new Router( include( '../app/config/routes.php' ));

        $route =  $router->parseRoute();

        try {
            if (!empty($route)) {
                $controllerReflection = new \ReflectionClass($route['controller']);

                $action = $route['action'] . 'Action';

                if ($controllerReflection->hasMethod($action)) {

                    if( $controllerReflection->isInstantiable() ) {

                        $controller = $controllerReflection->newInstance();

                        if( $controllerReflection->hasMethod( $action )) {
                            $actionReflection = $controllerReflection->getMethod($action);

                            $response = $actionReflection->invokeArgs($controller, $route['params']);

                            if ( !( $response instanceof Response )) {
                                throw new BadResponseTypeException;
                            }
                        }
                    }
                }
            }
            else {
                throw new HttpNotFoundException;
            }
        }
        catch( HttpNotFoundException $e ) {
            $e->getMessage();
        }
        catch( BadResponseTypeException $e) {
            $e->getMessage();
        }
        catch( \Exception $e ) {
            echo $e->getMessage();
        }
        $response->send();
    }
}