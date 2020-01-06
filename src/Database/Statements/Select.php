<?php

namespace Core\Database\Statements;

class Select
{
    private static $query;

    public static function generate($columns)
    {
        $columns = !in_array('*', $columns) ? implode(', ', $columns) : '*';

        static::$query = 'SELECT '.$columns.' FROM ';

        return static::$query;
    }
}
