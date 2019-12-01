<?php

namespace Core\Database\Statements;

class Having
{
    /**
     * Generated Query
     *
     * @var string
     */
    private static $query;
    
    public static function generate($column, $operator, $value)
    {   
        static::$query = " HAVING ". $column . $operator . ' ? ';

        return static::$query;
    }
}