<?php

namespace Framework\Validation;


class Validator {

    protected $objValidation;
    protected $errorLog = [];

    public function __construct( $obj ) {
        $this->objValidation = $obj;
    }

    public function isValid() {

        $result = true;

        $arrayRules = $this->objValidation->getRules();
        $properties = get_object_vars( $this->objValidation );

        foreach( $arrayRules as $name => $rules ) {

            if( array_key_exists( $name, $properties )) {

                foreach( $rules as $rule ) {

                    $isValid = $rule->isValid( $properties[$name] );

                    if( $isValid == false ) {
                        $this->errorLog[$name] = ucfirst( $name ).' is wrong.';
                        $result = false;
                        break;
                    }
                }
            }
        }

        return $result;
    }

    public function getErrors() {
        return $this->errorLog;
    }
}