<?php

namespace Core\Database\Statements;

class Select extends AbstractQuery
{
    private static $query;
    
    public static function generate($params)
    {
        $columns = implode(', ', $params);

        static::$query = "SELECT ". $columns . " FROM ";

        return static::$query;
    }
}