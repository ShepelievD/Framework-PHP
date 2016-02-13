<?php

namespace Framework;
use Framework\Router\Router;

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
        $route =  $router->parseRoute( $_SERVER[ 'REQUEST_URI' ] );

        if( !empty( $route )){
            echo '<pre>';
            print_r( $route );
        }
        else {
            echo 'The page hasn\' found. 404 ';
        }


    }
}