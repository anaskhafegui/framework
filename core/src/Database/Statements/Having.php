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
    
    /**
     * Generated Params for Query
     *
     * @var mixed
     */
    private static $bindings = [];
    
    public static function generate($column, $operator, $value)
    {   
        static::$query = " HAVING ". $column . $operator . ' ? ';
        static::$bindings[] = $value;

        return [static::$query, static::$bindings];
    }
}