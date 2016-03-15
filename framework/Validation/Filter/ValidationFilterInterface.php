<?php

namespace Framework\Validation\Filter;


interface ValidationFilterInterface {

    public function isValid( $value );
}