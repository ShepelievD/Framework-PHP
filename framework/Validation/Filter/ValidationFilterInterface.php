<?php

namespace Framework\Validation\Filter;


interface ValidationFilterInterface {

    /**
     * @param $value
     * @return mixed
     */

    public function isValid( $value );
}