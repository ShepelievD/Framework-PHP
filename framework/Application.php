<?php

namespace Framework;

use Framework\DI\Service;
use Framework\Event\Event;
use Framework\Exception\HttpNotFoundException;
use Framework\Exception\BadResponseTypeException;
use Framework\Renderer\Renderer;
use Framework\Request\Request;
use Framework\Response\Response;
use Framework\Response\ResponseRedirect;
use Framework\Router\Router;
use Framework\Security\Security;
use Framework\Session\Session;
use Framework\Exception\AccessDenyException;


/**
 * Class Application
 * @package Framework
 */

class Application {

    private $pathEvent = [];

    public function __construct( $path ) {

        if( file_exists( $path )) {

            Service::set('config', include($path));

            $pathEvents = realpath(str_replace('config.php', 'events.php', $path));
            $this->pathEvent = $pathEvents;

            $event = new Event( $this->pathEvent );
            $event->trigger('app.init');
            $event->trigger('db.setUTF8');
        }
    }

    /**
     * Destructor for closing DB connection
     */

    public function __destruct() {
        $event = new Event( $this->pathEvent );
        $event->trigger('db.closeDB');
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
                if( array_key_exists('security', $route) ) {

                    $user = Service::get('security')->getUser();
                    $allowed = Service::get('security')->checkGrants( $user );

                    if( !$allowed ){
                        throw new AccessDenyException();
                    }
                }


                $controllerReflection = new \ReflectionClass($route['controller']);

                $action = $route['action'] . 'Action';

                if ($controllerReflection->hasMethod($action)) {
                    if ($controllerReflection->isInstantiable()) {
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
        catch( AccessDenyException $e ){
            $response = new ResponseRedirect('/login');
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