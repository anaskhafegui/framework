<?php

namespace Core\Database;

class GroupBy extends AbstractQuery
{
    private static $query;
    
    public static function generate($params)
    {
        static::$query  = " GROUP BY ". implode (', ', $params) . " ";

        return static::$query;
    }
}