<?php

namespace Core\Database\Statements;

class GroupBy
{
    private static $query;

    public static function generate($column)
    {
        static::$query = ' GROUP BY '.$column.' ';

        return static::$query;
    }
}
