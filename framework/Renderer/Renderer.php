<?php

namespace Framework\Renderer;

use Framework\DI\Service;

class Renderer {

    protected $mainTemplate;

    public function __construct( ){
        $this->mainTemplate = realpath( Service::get('config')['main_layout'] );
    }

    public function renderMain($content) {

        // @TODO: flush and user

        $flush = [];
        $user = null;

        return $this->render($this->mainTemplate, compact('content', 'user', 'flush'), false);
    }

    public function renderException( $params ) {
        $this->render( Service::get('config')['error_505'], $params );
    }

    public function render($templatePath, $data, $wrap = true){

        $templatePath = realpath( $templatePath );

        // @TODO: closers

        $include = function() {
        };

        $generateToken = function(){
        };

        $getRoute = function($name){
            if( array_key_exists( $name, Service::get('routes'))) {
                $controller = Service::get('routes')[$name]['pattern'];
                echo $controller;
            }
        };

        $data['include'] = $include;
        $data['generateToken'] = $generateToken;
        $data['getRoute'] = $getRoute;

        extract($data);

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