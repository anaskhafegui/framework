<?php

namespace Core\Database\Statements;

class OrderBy
{
    private static $query;

    public static function generate($column, $type)
    {
        $orderBy = $column.' '.$type;

        if (is_null(static::$query)) {
            // if orderBy not exists before
            $statement = ' ORDER BY '.$orderBy;
        } else {
            $statement = ', '.$orderBy;
        }

        static::$query .= $statement;

        return static::$query;
    }
}
