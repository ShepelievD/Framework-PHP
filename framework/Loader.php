<?php

/**
 * Class Loader
 *
 * Realisation Singleton pattern
 */

class Loader {

    protected static $instance = null;
    protected static $namespace = array();

    /**
     * @return Loader|null
     */
    public static function getInstance()
    {
        if( empty( self::$instance )) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Loader constructor.
     */
    private function __construct()
    {
        spl_autoload_register( array( __CLASS__, 'load' ));
    }

    /**
     * @param $namespace
     * @param $path
     *
     * Create relation between namespace and path
     */
    public static function addNamespacePath( $namespace, $path )
    {
        Loader::$namespace[ $namespace ] = $path;
    }

    /**
     * @param $className
     */
    public static function load ( $className )
    {
        $segments = explode("\\", $className);

        $path = __DIR__.'/'.'Controller'.'/'.$segments[1].'.php';

        if( file_exists( $path )) {
            include_once( $path );
        }
    }
}

Loader::getInstance();