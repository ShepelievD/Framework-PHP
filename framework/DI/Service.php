<?php

namespace Framework\DI;


class Service
{
    private static $services = [];

    public static function set( $name, $obj ) {
        self::$services[$name] = $obj;
    }

    public static function get( $name ) {

        $res = null;

        if( array_key_exists( $name, self::$services )) {
            $res = self::$services[$name];
        }

        return $res;
    }

}