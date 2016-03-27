<?php

namespace Framework\Renderer;

use Framework\DI\Service;

class Renderer {

    /**
     * Main template
     *
     * @var string
     */

    protected $mainTemplate;

    /**
     * Renderer constructor.
     * Fills main template
     */

    public function __construct( ){
        $this->mainTemplate = realpath( Service::get('config')['main_layout'] );
    }

    /**
     * Renders main
     *
     * @param $content
     * @return string
     */

    public function renderMain($content) {

        $flush = [];
        $user = Service::get('security')->getUser();

        return $this->render($this->mainTemplate, compact('content', 'user', 'flush'), false);
    }

    /**
     * Renders exceptions
     *
     * @param $params
     */

    public function renderException( $params ) {
        $this->render( Service::get('config')['error_505'], $params );
    }

    /**
     * Renders
     *
     * @param $templatePath
     * @param $data
     * @param bool|true $wrap
     * @return string
     */

    public function render($templatePath, $data, $wrap = true){

        $templatePath = realpath( $templatePath );

        $include = function($controller, $action, $args = array()) {
            $controllerInstance = new $controller();
            if ($args === null) {
                $args = array();
            }

            return call_user_func_array(array($controllerInstance, $action.'Action'), $args);
        };

        $generateToken = function(){
            $token = md5('solt_string'.uniqid());
            setcookie('token', $token);
            echo '<input type="hidden" value="'.$token.'" name="token">';
        };

        $getRoute = function($name){
            if( array_key_exists( $name, Service::get('routes'))) {
                $uri = Service::get('routes')[$name]['pattern'];
                return $uri;
            }
        };

        extract( $data );

        ob_start();

        if( file_exists( $templatePath )) {
            include($templatePath);
        }
        $content = ob_get_contents();

        ob_end_clean();

        if($wrap){
            $content = $this->renderMain($content);
        }

        return $content;
    }
}