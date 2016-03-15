<?php

namespace Framework\Validation\Filter;


class NotBlank implements ValidationFilterInterface {

    public function isValid( $value ) {

        return !empty( $value );
    }
}