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
     * Blocked __clone for protecting the one instance.
     */
    private function __clone()
    {
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
        self::$namespace[ $namespace ] = $path;
    }

    /**
     * @param $className
     */
    public static function load ( $className )
    {

        $segments = explode("\\", $className);

        $pathDirectory = self::$namespace[$segments[0].'\\'];

        for( $i = 1; $i < count($segments) - 1; $i++ ) {
            $pathDirectory = $pathDirectory.'/'.$segments[$i];
        }

        $fileName = '/'.$segments[count($segments) - 1].'.php';

        if(is_dir($pathDirectory)) {
            $filePath = $pathDirectory.$fileName;
            if( file_exists( $filePath )) {
                include_once( $filePath );
            }
        }
    }
}

Loader::getInstance();
Loader::addNamespacePath('Framework\\', __DIR__);