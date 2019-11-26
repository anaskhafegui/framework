<?php

namespace Core\Database\Statements;

class Limit extends AbstractQuery
{
    private static $query;
    
    public static function generate($params)
    {
        list($limit) = $params;
         
        static::$query = " LIMIT ". $limit;

        return static::$query;
    }
}