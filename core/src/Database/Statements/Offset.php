<?php

namespace Core\Database\Statements;

class Offset extends AbstractQuery
{
    private static $query;
    
    public static function generate($params)
    {
        list($offset) = $params;
         
        static::$query = " OFFSET ". $offset;

        return static::$query;
    }
}