<?php

namespace Framework\Model;

use Framework\DI\Service;

/**
 * Class ActiveRecord
 * @package Framework\Model
 */

abstract class ActiveRecord {

    /**
     * Returns instance of DB or null
     *
     * @return null
     */

    static function getDbConnection() {
        return Service::get('db');
    }

    /**
     * Serves for finding posts
     *
     * @param string $id
     * @return array
     */

    static function find($id = 'all') {

        $db = ActiveRecord::getDbConnection();
        $table = static::getTable();

        if ($id == 'all') {

            $result = [];

            $query = $db->prepare("SELECT * FROM $table ORDER BY id");
            $query->execute();

            while ($row = $query->fetchObject()) {
                array_push($result, $row);
            }
        } else {
            $query = $db->prepare("SELECT * FROM $table WHERE id = :id");
            $query->execute([':id' => $id]);

            $result = $query->fetchObject();
        }
        return $result;
    }


    /**
     * Serves for saving
     *
     * @return mixed
     */
    public function save() {

        $fieldsForSave = get_object_vars( $this );

        $columnQueue = '';
        $valueQueue = '';

        foreach( $fieldsForSave as $key => $value ) {
            $columnQueue = $columnQueue . $key . ', ';
            $valueQueue = $valueQueue . '"' . addslashes( htmlspecialchars( $value ) ) . '", ';
        }

        var_dump( $columnQueue );
        var_dump( $valueQueue );

        $columnQueue = substr( $columnQueue, 0, -2 );
        $valueQueue = substr( $valueQueue, 0, -2 );

        $query = "REPLACE INTO " . static::getTable() . "( " . $columnQueue . ") VALUES ( " . $valueQueue . ")";

        $db = self::getDbConnection();

        $db->beginTransaction();
        $db->query( $query );
        $db->commit();
    }

    /**
     * Serves for calling functions "findBy*"
     *
     * @param $name
     * @param $arguments
     * @return bool
     */
    static public function __callStatic($name, $arguments) {

        $result = null;

        if( stristr( $name, 'findBy' ) !== false ){

            $db = self::getDbConnection();
            $table = static::getTable();

            $attr = lcfirst( str_replace( 'findBy', '', $name ) );

            $query = $db->prepare( "SELECT * FROM {$table} WHERE $attr = :{$attr}" );
            $query->execute( [ ":{$attr}" => $arguments[ 0 ] ] );

            $resultQuery = $query->fetchObject();

            $result = $resultQuery;
        }
        return $result;
    }

    /**
     * Removes post from DB
     *
     * @param $id
     */

    static function remove( $id ) {

        $db = self::getDbConnection();
        $table = static::getTable();

        if( is_numeric( $id ) ){
            $query = $db->prepare( "DELETE FROM $table WHERE id = " . $id . ";" );
            $query->execute();
        }
    }
}