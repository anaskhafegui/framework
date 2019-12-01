<?php

namespace Core\Database\Statements;

class GroupBy
{
    private static $query;
    
    public static function generate($params)
    {
        static::$query  = " GROUP BY ". implode (', ', $params) . " ";

        return static::$query;
    }
}