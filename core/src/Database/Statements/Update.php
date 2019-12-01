<?php

namespace Core\Database\Statements;

class Update extends AbstractQuery
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

        // get where bindings
        $whereBindings = $params['where_bindings'];

        // remove elements which are useless
        unset($params['where_statement']);
        unset($params['where_bindings']);

        // set the update statement bindings
        static::$bindings[] = $params;

        if (isset($whereBindings) && isset($whereStatement)) {

            // set the where bindings
            static::$bindings[] = $whereBindings;

            // compile the where statement
            static::$query .= $whereStatement;
        }

    
        static::$bindings = flatten(static::$bindings);
        
        return [static::$query, static::$bindings];
    }
}