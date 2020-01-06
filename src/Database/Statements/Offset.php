<?php

namespace Core\Database\Statements;

class Offset
{
    private static $query;

    public static function generate($offset)
    {
        static::$query = ' OFFSET '.$offset;

        return static::$query;
    }
}
