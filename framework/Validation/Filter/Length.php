<?php

namespace Framework\Validation\Filter;


class Length implements ValidationFilterInterface {

    protected $min;
    protected $max;

    public function __construct( $min, $max ) {
        if( $min > 0 && $max >= $min) {
            $this->min = $min;
            $this->max = $max;
        }
        else {
            $this->min = 0;
            $this->max = 5;
        }
    }

    public function isValid( $value ) {

        $lenValue = strlen( $value );

        return ( $this->min <= $lenValue && $lenValue <= $this->max );
    }
}