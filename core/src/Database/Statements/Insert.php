<?php

namespace Core\Database\Statements;

class Insert extends AbstractQuery
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
            $columns [] = $column ." = ?";
        }

        static::$query = "INSERT INTO " .$table ." SET " . implode(",", $columns);

        static::$bindings[] = array_values($params);

        return static::$query;
    }
}