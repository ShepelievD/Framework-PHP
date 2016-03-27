<?php

namespace Framework\Event;

/**
 * Class Event
 * @package Framework\Event
 */


class Event {

    /**
     * array of events
     * Path of events(events.php) is near config.php
     *
     * @var array|mixed
     */

    protected $mapEvents = [];

    /**
     * Event constructor.
     *
     * @param $path
     */
    public function __construct( $path ) {
        if( file_exists( $path ) ){
            $this->mapEvents = include( $path );
        }
    }

    /**
     * Calls needed method
     *
     * @param $nameEvent
     */
    public function trigger( $nameEvent ){

        if( array_key_exists( $nameEvent, $this->mapEvents ) ){

            $classAndMethod = $this->mapEvents[ $nameEvent ];
            $segments = explode( '@', $classAndMethod );
            $calledClass = $segments[ 0 ];

            $calledMethod = $segments[ 1 ];

            $classReflection = new \ReflectionClass( $calledClass );

            if( $classReflection->hasMethod( $calledMethod ) ){
                $instance = $classReflection->newInstance();
                $reflectionMethod = $classReflection->getMethod( $calledMethod );
                $reflectionMethod->invokeArgs( $instance, [ ] );
            }
        }
    }
}