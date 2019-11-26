<?php

namespace Core\Database\Statements;

class Having extends AbstractQuery
{
    private static $query;
    
    public static function generate($params)
    {
        list($column, $operator, $value) = $params;
        
        static::$query = " HAVING ". $column . $operator . $value;

        return static::$query;
    }
}