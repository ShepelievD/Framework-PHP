<?php

class Loader {

    protected static $instance = null;
    protected static $namespace = array();

    public static function getInstance()
    {
        if( empty( self::$instance )) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct()
    {
        spl_autoload_register( array( __CLASS__, 'load' ));
    }

    public static function addNamespacePath( $namespace, $path )
    {
        if( empty( Loader::$namespace )) {
            Loader::$namespace[ $namespace ] = $path;
        }
        else {
            $isKnown = false;
            foreach (Loader::$namespace as $key => $value) {

                if( $key == $namespace ) {

                    $isKnown = true;
                    break;
                }
            }

            if( !$isKnown ) {
                Loader::$namespace[ $namespace ] = $path;
            }
        }

        var_dump(Loader::$namespace);
    }

    public static function load ( $className )
    {
        $segments = explode("\\", $className);

        $path = __DIR__.'/'.$segments[1].'.php';

        if( file_exists( $path )) {
            include_once( $path );
        }
    }
}

Loader::getInstance();