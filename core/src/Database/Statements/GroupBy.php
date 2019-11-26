<?php

namespace Core\Database\Statements;

class GroupBy extends AbstractQuery
{
    private static $query;
    
    public static function generate($params)
    {
        static::$query  = " GROUP BY ". implode (', ', $params) . " ";

        return static::$query;
    }
}