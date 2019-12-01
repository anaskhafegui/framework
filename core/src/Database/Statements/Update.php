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
        $table = $params['table']; 
        unset($params['table']);


        foreach($params as $column => $value) {
            if ($column != 'where_bindings' && $column != 'where_statement'){
                $columns [] = $column ." = ?";
            }
            
        }

        static::$query = "UPDATE " .$table ." SET " . implode(",", $columns);

        $whereStatement = $params['where_statement'];
        $whereBindings = $params['where_bindings'];

        unset($params['where_statement']);
        unset($params['where_bindings']);

        static::$bindings[] = $params;

        if (isset($whereBindings) && isset($whereStatement)) {

            static::$bindings[] = $whereBindings;

            static::$query .= $whereStatement;
        }

    
        static::$bindings = flatten(static::$bindings);
        
        return [static::$query, static::$bindings];
    }
}