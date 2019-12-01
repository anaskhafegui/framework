<?php

namespace Core\Database\Statements;

class Insert
{
    /**
     * Generated Query
     *
     * @var string
     */
    private static $query;


    public static function generate($params=null)
    {
        $table = $params['table']; 
        unset($params['table']);
        
        foreach(array_keys($params) as $column) {
            $columns [] = $column ." = ?";
        }

        static::$query = "INSERT INTO " .$table ." SET " . implode(",", $columns);

        return static::$query;
    }
}