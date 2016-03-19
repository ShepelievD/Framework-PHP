<?php

namespace Framework\DI;


class Service
{
    /**
     * Container for DI
     *
     * @var array
     */

    private static $services = [];

    /**
     * Set dependency injection in container
     *
     * @param $name
     * @param $obj
     */

    public static function set( $name, $obj ) {
        self::$services[$name] = $obj;
    }

    /**
     * Get dependency injection from container
     *
     * @param $name
     * @return null
     */

    public static function get( $name ) {

        $res = null;

        if( array_key_exists( $name, self::$services )) {
            $res = self::$services[$name];
        }

        return $res;
    }

}