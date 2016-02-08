<?php

/**
 * Class Loader
 *
 * Realisation of Singleton pattern
 */

class Loader {

    protected static $instance = null;
    protected static $namespace = array();

    /**
     * The method allows to create only one instance
     *
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
     * Create relation between namespace and path
     *
     * @param $namespace
     * @param $path
     *
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

        $path = __DIR__;

        foreach( $segments as $key => $value) {
            if( $key == 0) {
                continue;
            }
            $path .= '/'.$value;
        }

        $path .= '.php';

        if( file_exists( $path )) {
            include_once( $path );
        }
    }
}

Loader::getInstance();