<?php

namespace Core\Database\Statements;

class Limit
{
    private static $query;
    
    public static function generate($params)
    {
        list($limit) = $params;
         
        static::$query = " LIMIT ". $limit;

        return static::$query;
    }
}