<?php

namespace Framework\Model;

use Framework\DI\Service;

abstract class ActiveRecord {

    static function getDbConnection() {
        return Service::get('db');
    }

    static function find( $id = 'all' ) {

        $db = ActiveRecord::getDbConnection();
        $table = static::getTable();

        if ( $id == 'all' ) {

            $result = [];

            $query = $db->prepare( "SELECT * FROM $table ORDER BY id" );
            $query->execute();

            while ( $row = $query->fetchObject() ) {
                $result = $row;
            }
        }
        else {
            $query = $db->prepare( "SELECT * FROM $table WHERE id = :id" );
            $query->execute( [ ':id' => $id ] );

            $result = $query->fetchObject();
        }
        return $result;
    }

    static function save() {

        $fieldsForSave = '';
        $valuesFields = [];

        $table = static::getTable();

        $fields = get_object_vars( $this );

        foreach ( $fields as $column => $value ) {
            if ( isset( $column )) {
                $fieldsForSave .= "'" . str_replace("'", '"', $column) . "'" . "=:$column, ";
                $valuesFields[":$column"] = $value;
            }
        }

        $fieldsForSave = substr( $fieldsForSave, 0, -2) ;

        $sql = "INSERT INTO " . $table . " SET " . $fieldsForSave;

        $statement = Service::get('db')->prepare($sql);

        $result = $statement->execute($valuesFields);

        if ( $result == true and strcmp( 'Blog\Model\User',  get_called_class())) {
            Service::get('security')->setUser( $this );
        }

        return $result;
    }

}