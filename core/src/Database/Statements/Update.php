<?php

namespace Core\Database\Statements;

class Update
{
    /**
     * Generated Query
     *
     * @var string
     */
    private static $query;

    /**
     * Generated Params for Query
     *
     * @var mixed
     */
    private static $bindings = [];

    public static function generate($params=null)
    {
        // set table name
        $table = $params['table']; 

        // remove table name from params array
        unset($params['table']);


        // get only the columns which need updates
        foreach($params as $column => $value) {
            if ($column != 'where_bindings' && $column != 'where_statement'){
                $columns [] = $column ." = ?";
            }   
        }

        static::$query = "UPDATE " .$table ." SET " . implode(",", $columns);

        // get where statement
        $whereStatement = $params['where_statement'];

        return static::$query . $whereStatement;
    }
}