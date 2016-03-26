<?php

namespace Framework\Validation;

/**
 * Class Validator
 * @package Framework\Validation
 */
class Validator {

    /**
     * Object of validation
     *
     * @var
     */

    protected $objValidation;

    /**
     * Log of error
     *
     * @var array
     */
    protected $errorLog = [];

    public function __construct( $obj ) {
        $this->objValidation = $obj;
    }

    /**
     * Checks is valid
     *
     * @return bool
     */

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

    /**
     * Returns Lof of error
     *
     * @return array
     */

    public function getErrors() {
        return $this->errorLog;
    }
}