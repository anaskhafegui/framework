<?php

namespace Core\Database\Statements;

class Limit
{
    private static $query;
    
    public static function generate($limit)
    {    
        static::$query = " LIMIT ". $limit;

        return static::$query;
    }
}