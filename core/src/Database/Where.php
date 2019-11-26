<?php

namespace Core\Database;

class Where
{
    private static $query;
    
    public static function generateQuery($column, $operator, $value, $type)
    {
        $where = $column . $operator . $value;
        
        if (is_null(static::$query)) {
            // if where not exists before
            $statement = " WHERE ". $where;
        } elseif(is_null($type)) {
            // if type not specified so set type as AND
            $statement = " AND ". $where;
        } else {
            $statement = " OR ". $where;
        }


        static::$query .= $statement;

        return static::$query;
    }

}